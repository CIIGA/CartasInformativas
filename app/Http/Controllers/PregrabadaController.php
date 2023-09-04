<?php

namespace App\Http\Controllers;

use App\Http\Requests\PregrabadasRequest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\DatabaseUtils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PregrabadaController extends Controller
{
    public function store(PregrabadasRequest $request)
    {
        $request->validated();
        $idPlaza = $request->idPlaza;
        $fechaI = $request->fechaI;
        $fechaF = $request->fechaf;
        $databaseName1 = 'kpis';
        $connection1 = DatabaseUtils::getDynamicConnection($databaseName1);
        $plazas = DB::connection('dynamic')->select("SELECT [id_proveniente] as id,
         [nombreProveniente] as plaza ,[data] as bd FROM [implementtaAdministrator].[dbo].[proveniente]  
         WHERE [nombreProveniente] <> 'Implementta Demo' and id_proveniente=?;", [$idPlaza]);
        DB::disconnect('dynamic');
        if ($plazas == null) {
            return back()->with('error', 'No existe la plaza');
        }
        $bd = $plazas[0]->bd;
        $plaza = $plazas[0]->plaza;
        $databaseName2 = $bd;
        //mandamos a llamar al stored procedure
        $connection2 = DatabaseUtils::getDynamicConnection($databaseName2);
        $exec = DB::connection('dynamic')->select("exec sp_profile_operation_t25 ?, ?, ?", array($fechaI, $fechaF, 1));
        //si se ejecuta el procedimiento mandamos a llamar a la funcion index
        DB::disconnect('dynamic');
        if ($exec) {
            // return $this->pdfPregabadas($idPlaza, $plaza, $fechaF);

            return '<script type="text/javascript">window.open("pdfPregabadas/' . $idPlaza . '/'.$plaza.'/'.$fechaF.'")</script>' .
                redirect()->action(
                    [IndexController::class, 'index']
                );
        }
    }
    public function pdfPregabadas($idPlaza, $plaza, $fechaF)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        //Ruta imagen del reporte 
        // Verificar si existe la imagen de la plaza
        $rutaImagen = public_path('img/plazas/' . $idPlaza . '.jpg'); // Suponemos que las imágenes son archivos JPG
        $imagen=$idPlaza;
        if (!file_exists($rutaImagen)) {
            // return response()->json(['error' => 'No se encontró la imagen para la plaza seleccionada.'], 404);
            // Obtener el contenido de la imagen por defecto
            $imagen = 'default';
        }
        //Tabla 1 
        $anio = anio($fechaF);
        $mes = mes($fechaF);
        $databaseName1 = 'kpimplementta';
        $connection1 = DatabaseUtils::getDynamicConnection($databaseName1);
        $tabla1Pregrabada = DB::connection('dynamic')->select("select concepto, sum(cantidad) as cantidad  
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and 
        tipo='Pregrabadas' and tabla ='1. General' group by concepto", [$plaza, $mes, $anio]);
        DB::disconnect('dynamic');
        if ($tabla1Pregrabada == null) {
            return back()->with('error', 'No hay informacion.');
        }
        $cantidad1 =  $tabla1Pregrabada[0]->cantidad;
        $cantidad2 = $tabla1Pregrabada[1]->cantidad;
        $total1 = $cantidad1 + $cantidad2;
        $result1 = ($cantidad1 / $total1) * 100;
        $result2 = ($cantidad2 / $total1) * 100;
        $result1 = redondearNumero($result1);
        $result2 = redondearNumero($result2);
        //Tabla 2
        $tabla2Pregrabada = DB::connection('dynamic')->select("select concepto, sum(cantidad) as cantidad  
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero =? and año = ? and 
        tipo='Pregrabadas' and tabla ='2. Desglose' group by concepto", [$plaza, $mes, $anio]);
        DB::disconnect('dynamic');
        $cantidad11 =  $tabla2Pregrabada[0]->cantidad;
        $cantidad22 = $tabla2Pregrabada[1]->cantidad;
        $cantidad33 =  $tabla2Pregrabada[2]->cantidad;
        $cantidad44 = $tabla2Pregrabada[3]->cantidad;
        $total22 = $cantidad11 +
            $cantidad22 +
            $cantidad33 +
            $cantidad44;
        $result11 = ($cantidad11 / $total22) * 100;
        $result22 = ($cantidad22 / $total22) * 100;
        $result33 = ($cantidad33 / $total22) * 100;
        $result44 = ($cantidad44 / $total22) * 100;
        $result11 = redondearNumero($result11);
        $result22 = redondearNumero($result22);
        $result33 = redondearNumero($result33);
        $result44 = redondearNumero($result44);
        //Nombre de la plaza 
        $nombre = extraerPrimeraPalabra($plaza);
        //Formato de fecha formateada
        $fechaFormateada = fechaReporte(0, $fechaF);
        //declaramos la variable pdf y mandamos los parametros
        return view(
            'pdf.pregrabadas',
            [
                'tabla1Pregrabada' => $tabla1Pregrabada,
                'tabla2Pregrabada' => $tabla2Pregrabada,
                'result1' => $result1,
                'result2' => $result2,
                'total1' => $total1,
                'result11' => $result11,
                'result22' => $result22,
                'result33' => $result33,
                'result44' => $result44,
                'total22' => $total22,
                'rutaImagen' => $imagen,
                //Nombre plaza 
                'nombre' => $nombre,
                //Fecha formateada
                'fechaFormateada' => $fechaFormateada,
                'idPlaza' => $idPlaza,
                'plaza' => $plaza,
                'fechaF' => $fechaF
            ]
        );
    }
    public function GenerarPDFPregrabada(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $fechaF= $request->fechaF;
        $plaza= $request->plaza;
        $idPlaza= $request->idPlaza;
        $imagenContestadas= $request->imagenContestadas;
        $imagenSeguimiento= $request->imagenSeguimiento;
        //Ruta imagen del reporte 
        // Verificar si existe la imagen de la plaza
        $rutaImagen = public_path('img/plazas/' . $idPlaza . '.jpg'); // Suponemos que las imágenes son archivos JPG
        if (!file_exists($rutaImagen)) {
            // return response()->json(['error' => 'No se encontró la imagen para la plaza seleccionada.'], 404);
            // Obtener el contenido de la imagen por defecto
            $rutaImagen = public_path('img/plazas/default.jpg');
        }
        //Tabla 1 
        $anio = anio($fechaF);
        $mes = mes($fechaF);
        $databaseName1 = 'kpimplementta';
        $connection1 = DatabaseUtils::getDynamicConnection($databaseName1);
        $tabla1Pregrabada = DB::connection('dynamic')->select("select concepto, sum(cantidad) as cantidad  
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and 
        tipo='Pregrabadas' and tabla ='1. General' group by concepto", [$plaza, $mes, $anio]);
        DB::disconnect('dynamic');
        if ($tabla1Pregrabada == null) {
            return back()->with('error', 'No hay informacion.');
        }
        $cantidad1 =  $tabla1Pregrabada[0]->cantidad;
        $cantidad2 = $tabla1Pregrabada[1]->cantidad;
        $total1 = $cantidad1 + $cantidad2;
        $result1 = ($cantidad1 / $total1) * 100;
        $result2 = ($cantidad2 / $total1) * 100;
        $result1 = redondearNumero($result1);
        $result2 = redondearNumero($result2);
        //Tabla 2
        $tabla2Pregrabada = DB::connection('dynamic')->select("select concepto, sum(cantidad) as cantidad  
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero =? and año = ? and 
        tipo='Pregrabadas' and tabla ='2. Desglose' group by concepto", [$plaza, $mes, $anio]);
        DB::disconnect('dynamic');
        $cantidad11 =  $tabla2Pregrabada[0]->cantidad;
        $cantidad22 = $tabla2Pregrabada[1]->cantidad;
        $cantidad33 =  $tabla2Pregrabada[2]->cantidad;
        $cantidad44 = $tabla2Pregrabada[3]->cantidad;
        $total22 = $cantidad11 +
            $cantidad22 +
            $cantidad33 +
            $cantidad44;
        $result11 = ($cantidad11 / $total22) * 100;
        $result22 = ($cantidad22 / $total22) * 100;
        $result33 = ($cantidad33 / $total22) * 100;
        $result44 = ($cantidad44 / $total22) * 100;
        $result11 = redondearNumero($result11);
        $result22 = redondearNumero($result22);
        $result33 = redondearNumero($result33);
        $result44 = redondearNumero($result44);
        //Nombre de la plaza 
        $nombre = extraerPrimeraPalabra($plaza);
          //Formato de fecha formateada
          $fechaFormateada = fechaReporte(0, $fechaF);
        //declaramos la variable pdf y mandamos los parametros
        $pdf = Pdf::loadView(
            'pdf.pregrabadas2',
            [
                'tabla1Pregrabada' => $tabla1Pregrabada,
                'tabla2Pregrabada' => $tabla2Pregrabada,
                'result1' => $result1,
                'result2' => $result2,
                'total1' => $total1,
                'result11' => $result11,
                'result22' => $result22,
                'result33' => $result33,
                'result44' => $result44,
                'total22' => $total22,
                'rutaImagen' => $rutaImagen,
                //Nombre plaza 
                'nombre' => $nombre,
                //Fecha Formateada
                'fechaFormateada'=>$fechaFormateada,
                'imagenSeguimiento'=>$imagenSeguimiento,
                'imagenContestadas'=>$imagenContestadas,
            ]
        );
        return $pdf->stream();
    }
}
