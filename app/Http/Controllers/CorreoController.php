<?php

namespace App\Http\Controllers;

use App\DatabaseUtils;
use App\Http\Requests\CorreoRequest;
use App\Models\Correo;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class CorreoController extends Controller
{
    public function show(Request $request)
    {

        $fecha = $request->fecha;
        $databaseName3 = 'kpimplementta';
        $connection2 = DatabaseUtils::getDynamicConnection($databaseName3);
        $datos = DB::connection('dynamic')->table('historicoCampaniaCorreo')
            ->where('fecha_enviado', $fecha)
            ->paginate(20);
        DB::disconnect('dynamic');
        return response()->json($datos);
    }
    public function store(CorreoRequest $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $request->validated();
        $archivo = $request->file('fileExcel');
        // Verificar si se subió el archivo correctamente
        if ($archivo) {
            // Utilizar la función toCollection para cargar los datos desde el archivo
            $collection = Excel::toCollection(null, $archivo, null, null, false, 'UTF-8');
            // Si hay datos en la colección
            if (!$collection->isEmpty()) {
                // Obtener los datos del primer elemento de la colección
                $data = $collection->first()->toArray();
                // Verificar si los encabezados son correctos
                $expectedHeaders = ['Cuenta', 'Fecha_Leido', 'Fecha_enviado'];
                $actualHeaders = $data[0];
                if ($actualHeaders !== $expectedHeaders) {
                    return redirect()->back()->with('error', 'El archivo no tiene los encabezados correctos.');
                }
                // Obtener la conexión dinámica
                $databaseName2 = 'kpimplementta';
                $connection = DatabaseUtils::getDynamicConnection($databaseName2);
                // Insertar los datos en la tabla utilizando Eloquent en lotes
                $chunkSize = 100;
                $dataChunks = array_chunk(array_slice($data, 1), $chunkSize);
                foreach ($dataChunks as $chunk) {
                    foreach ($chunk as $row) {
                        if ($row[0] !== null) {
                            $insertar2 = new Correo();
                            $insertar2->setConnection('dynamic');
                            $insertar2->cuenta = $row[0];
                            $insertar2->fecha_leido = formatoFechaInt($row[1]);
                            $insertar2->fecha_enviado = formatoFechaInt($row[2]);
                            $insertar2->idPlaza = $request->idPlaza;
                            $insertar2->save();
                        } else {
                            return redirect()->back()->with('error', 'Se encontro el campo cuenta vacio');
                        }
                    }
                }
                // Desconectar la conexión dinámica
                DB::disconnect('dynamic');
            }
            return redirect()->back()->with('success', 'Datos cargados exitosamente.');
        } else {
            return redirect()->back()->with('error', 'No se ha subido ningún archivo.');
        }
    }
    public function pdfCorreo($idPlaza, $fecha)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        //Remplaznado fecha de - por /
        $fecha = str_replace('-', '/', $fecha);
        //Ruta imagen del reporte 
        // Verificar si existe la imagen de la plaza
        $rutaImagen = public_path('img/plazas/' . $idPlaza . '.jpg'); // Suponemos que las imágenes son archivos JPG
        $imagen=$idPlaza;
        if (!file_exists($rutaImagen)) {
            // Obtener el contenido de la imagen por defecto
            $imagen = 'default';
        }
        //Consulta de las plazas 
        $databaseName1 = 'kpis';
        $connection1 = DatabaseUtils::getDynamicConnection($databaseName1);
        $plazas = DB::connection('dynamic')->select("SELECT [id_proveniente] as id,
         [nombreProveniente] as plaza ,[data] as bd FROM [implementtaAdministrator].[dbo].[proveniente]  
         WHERE [nombreProveniente] <> 'Implementta Demo' and id_proveniente=?;", [$idPlaza]);
        DB::disconnect('dynamic');
        $plaza = $plazas[0]->plaza;
        //Nombre de la plaza 
        $nombre = extraerPrimeraPalabra($plaza);
        //Consulta del reporte
        $databaseName2 = 'kpimplementta';
        $connection2 = DatabaseUtils::getDynamicConnection($databaseName2);
        $datos = DB::connection('dynamic')->select("select a.total, b.NotNull, c.Nulos from 
        (select count(*) as total from historicoCampaniaCorreo where fecha_enviado=?) as a, 
        (select count(*) as NotNull from historicoCampaniaCorreo where fecha_enviado=? and fecha_leido is not null) as b,
        (select count(*) as Nulos from historicoCampaniaCorreo where fecha_enviado=? and fecha_leido is null) as c", [$fecha, $fecha, $fecha]);
        DB::disconnect('dynamic');
        if ($datos[0] == null) {
            return redirect()->back()->with('error', 'No informacion en esa fecha');
        }
        $total = $datos[0]->total;
        $enviados = $datos[0]->NotNull;
        $nulos = $datos[0]->Nulos;

        $result1 = ($enviados / $total) * 100;
        $result2 = ($nulos / $total) * 100;
        //Formato de fecha formateada
        $fechaFormateada = fechaReporte(0, $fecha);
        return view(
            'pdf.correo',
            [
                'total' => $total,
                'enviados' => $enviados,
                'nulos' => $nulos,
                'result1' => $result1,
                'result2' => $result2,
                //Ruta de imagen
                'rutaImagen' => $imagen,
                //Nombre plaza 
                'nombre' => $nombre,
                'idPlaza' => $idPlaza,
                'fecha' => $fecha,
                'fechaFormateada' => $fechaFormateada
            ]
        );
    }
    public function GenerarPDFCorreo(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $fecha = $request->fecha;
        $idPlaza = $request->idPlaza;
        $imagen = $request->imagen;
        //Remplaznado fecha de - por /
        $fecha = str_replace('-', '/', $fecha);
        //Ruta imagen del reporte 
        // Verificar si existe la imagen de la plaza
        $rutaImagen = public_path('img/plazas/' . $idPlaza . '.jpg'); // Suponemos que las imágenes son archivos JPG
        if (!file_exists($rutaImagen)) {
            // Obtener el contenido de la imagen por defecto
            $rutaImagen = public_path('img/plazas/default.jpg');
        }
        //Consulta de las plazas 
        $databaseName1 = 'kpis';
        $connection1 = DatabaseUtils::getDynamicConnection($databaseName1);
        $plazas = DB::connection('dynamic')->select("SELECT [id_proveniente] as id,
         [nombreProveniente] as plaza ,[data] as bd FROM [implementtaAdministrator].[dbo].[proveniente]  
         WHERE [nombreProveniente] <> 'Implementta Demo' and id_proveniente=?;", [$idPlaza]);
        DB::disconnect('dynamic');
        $plaza = $plazas[0]->plaza;
        //Nombre de la plaza 
        $nombre = extraerPrimeraPalabra($plaza);
        //Consulta del reporte
        $databaseName2 = 'kpimplementta';
        $connection2 = DatabaseUtils::getDynamicConnection($databaseName2);
        $datos = DB::connection('dynamic')->select("select a.total, b.NotNull, c.Nulos from 
        (select count(*) as total from historicoCampaniaCorreo where fecha_enviado=?) as a, 
        (select count(*) as NotNull from historicoCampaniaCorreo where fecha_enviado=? and fecha_leido is not null) as b,
        (select count(*) as Nulos from historicoCampaniaCorreo where fecha_enviado=? and fecha_leido is null) as c", [$fecha, $fecha, $fecha]);
        DB::disconnect('dynamic');
        if ($datos[0] == null) {
            return redirect()->back()->with('error', 'No informacion en esa fecha');
        }
        $total = $datos[0]->total;
        $enviados = $datos[0]->NotNull;
        $nulos = $datos[0]->Nulos;
        $result1 = ($enviados / $total) * 100;
        $result2 = ($nulos / $total) * 100;
        //Formato de fecha formateada
        $fechaFormateada = fechaReporte(0, $fecha);
        $pdf = Pdf::loadView(
            'pdf.correo2',
            [
                'total' => $total,
                'enviados' => $enviados,
                'nulos' => $nulos,
                'result1' => $result1,
                'result2' => $result2,
                //Ruta de la imagen 
                'rutaImagen' => $rutaImagen,
                //Nombre plaza 
                'nombre' => $nombre,
                'imagen' => $imagen,
                'fechaFormateada' => $fechaFormateada
            ]
        );
        return $pdf->stream();
    }

    public function fechas($idPlaza){
        
        $databaseName1= 'kpimplementta';
        $connection1 = DatabaseUtils::getDynamicConnection($databaseName1);
        $historico = DB::connection('dynamic')->select("select fecha_enviado from historicoCampaniaCorreo where idPlaza=$idPlaza
        group by fecha_enviado order by fecha_enviado desc");
        DB::disconnect('dynamic');
            $contenido = View::make('form.formCorreo', ['historico' => $historico,'idPlaza' => $idPlaza])->render();
       
        
        //retornamos la respuesta json
        return response()->json(['contenido' => $contenido]);
    }
}
