<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\DatabaseUtils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        $request->validated();
        $idPlaza = $request->idPlazaC;
        $fechaI = $request->fechaIC;
        $fechaF = $request->fechafC;
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
        if ($exec[0]->resultado == 1) {
            $anio = anio($fechaF);
            $mes = mes($fechaF);
            //Tabla 1
            $databaseName3 = 'kpimplementta';
            $connection3 = DatabaseUtils::getDynamicConnection($databaseName3);
            $tabla1General = DB::connection('dynamic')->select("select sum(cantidad) as c 
            from [kpimplementta].[dbo].[profile_operation_t25] where 
            plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
            and tabla ='1. General'", [$plaza, $mes, $anio]);
            DB::disconnect('dynamic');
            if ($tabla1General[0]->c == null) {
                return back()->with('error', 'No hay información en este rango de fechas.');
            } else {
                if ($tabla1General[0]->c != 0) {
                    return '<script type="text/javascript">window.open("pdfContact/' . $idPlaza . '/' . $plaza . '/' . $fechaF . '")</script>' .
                        redirect()->action(
                            [IndexController::class, 'index']
                        );
                } else {
                    return back()->with('error', 'No hay información en este rango de fechas.');
                }
            }
        } else {
            return back()->with('error', 'Error al ejecutar el proceso, intente de nuevo y si el problema persiste comuniquese con soporte');
        }
    }
    public function pdfContact($idPlaza, $plaza, $fechaF)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        //Ruta imagen del reporte 
        // Verificar si existe la imagen de la plaza
        $rutaImagen = public_path('img/plazas/' . $idPlaza . '.jpg'); // Suponemos que las imágenes son archivos JPG
        $imagen = $idPlaza;
        if (!file_exists($rutaImagen)) {
            // return response()->json(['error' => 'No se encontró la imagen para la plaza seleccionada.'], 404);
            // Obtener el contenido de la imagen por defecto
            $rutaImagen = public_path('img/plazas/default.jpg');
        }
        //Se extrae el año y la fecha 
        $anio = anio($fechaF);
        $mes = mes($fechaF);
        //Tabla 1
        $databaseName1 = 'kpimplementta';
        $connection1 = DatabaseUtils::getDynamicConnection($databaseName1);
        $tabla1General = DB::connection('dynamic')->select("select concepto, sum(cantidad) as cantidad 
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='1. General'  group by concepto", [$plaza, $mes, $anio]);
        
        $totalGeneral = DB::connection('dynamic')->select("select sum(cantidad) as total 
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='1. General'", [$plaza, $mes, $anio]);

        $General=0;
        foreach ($tabla1General as $item) {
            $General++;
        }
        
        DB::disconnect('dynamic');
        
        
        //Tabla 2
        $databaseName2 = 'kpimplementta';
        $connection2 = DatabaseUtils::getDynamicConnection($databaseName2);
        $tabla2Depuracion = DB::connection('dynamic')->select("select concepto, sum(cantidad) as cantidad 
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='2. Depuracion'  group by concepto", [$plaza, $mes, $anio]);
        
        $totalDepuracion = DB::connection('dynamic')->select("select sum(cantidad) as total 
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='2. Depuracion'", [$plaza, $mes, $anio]);

        $Depuracion=0;
        foreach ($tabla2Depuracion as $item) {
            $Depuracion++;
        }

        DB::disconnect('dynamic');
        
        //Tabla 3
        $databaseName3 = 'kpimplementta';
        $connection3 = DatabaseUtils::getDynamicConnection($databaseName3);
        $tabla3Contestadas = DB::connection('dynamic')->select("
        select concepto, sum(cantidad) as cantidad from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='3. Contestadas'  group by concepto", [$plaza, $mes, $anio]);
        
        $totalContestadas = DB::connection('dynamic')->select("
        select sum(cantidad) as total from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='3. Contestadas'", [$plaza, $mes, $anio]);

        $Contestadas=0;
        foreach ($tabla3Contestadas as $item) {
            $Contestadas++;
        }

        DB::disconnect('dynamic');
       
        //Tabla 4
        $databaseName4 = 'kpimplementta';
        $connection3 = DatabaseUtils::getDynamicConnection($databaseName4);
        $tabla4Seguimiento = DB::connection('dynamic')->select("
        select concepto, sum(cantidad) as cantidad from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='4. Seguimiento'  group by concepto", [$plaza, $mes, $anio]);
        
        $totalSeguimiento = DB::connection('dynamic')->select("
        select sum(cantidad) as total from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='4. Seguimiento'", [$plaza, $mes, $anio]);

        $Seguimiento=0;
        foreach ($tabla4Seguimiento as $item) {
            $Seguimiento++;
        }

        DB::disconnect('dynamic');
       
        //Nombre de la plaza 
        $nombre = extraerPrimeraPalabra($plaza);
        //Formato de fecha formateada
        $fechaFormateada = fechaReporte(0, $fechaF);
        //declaramos la variable pdf y mandamos los parametros
        return view(
            'pdf.contact',
            [
                //Tabla 1 General
                'tabla1General' => $tabla1General,
                'General' => $General,
                'totalGeneral' => $totalGeneral[0]->total,
                //Tabla 2 General
                'tabla2Depuracion' => $tabla2Depuracion,
                'Depuracion' => $Depuracion,
                'totalDepuracion' => $totalDepuracion[0]->total,
                //Tabla 3 Contestadas
                'tabla3Contestadas' => $tabla3Contestadas,
                'Contestadas' => $Contestadas,
                'totalContestadas' => $totalContestadas[0]->total,
                //Tabla 4
                'tabla4Seguimiento' => $tabla4Seguimiento,
                'Seguimiento' => $Seguimiento,
                'totalSeguimiento' => $totalSeguimiento[0]->total,
                //Ruta imagen
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
    public function GenerarPDFContact(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $fechaF = $request->fechaF;
        $plaza = $request->plaza;
        $idPlaza = $request->idPlaza;
        $imagenLlamadas = $request->imagenLlamadas;
        $imagenDesglose = $request->imagenDesglose;
        $imagenContestadas = $request->imagenContestadas;
        $imagenSeguimiento = $request->imagenSeguimiento;

        //Ruta imagen del reporte 
        // Verificar si existe la imagen de la plaza
        $rutaImagen = public_path('img/plazas/' . $idPlaza . '.jpg'); // Suponemos que las imágenes son archivos JPG
        if (!file_exists($rutaImagen)) {
            // return response()->json(['error' => 'No se encontró la imagen para la plaza seleccionada.'], 404);
            // Obtener el contenido de la imagen por defecto
            $rutaImagen = public_path('img/plazas/default.jpg');
        }
        //Se extrae el año y la fecha 
        $anio = anio($fechaF);
        $mes = mes($fechaF);
        //Tabla 1
        $databaseName1 = 'kpimplementta';
        $connection1 = DatabaseUtils::getDynamicConnection($databaseName1);
        $tabla1General = DB::connection('dynamic')->select("select concepto, sum(cantidad) as cantidad 
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='1. General'  group by concepto", [$plaza, $mes, $anio]);

        $totalGeneral = DB::connection('dynamic')->select("select sum(cantidad) as total 
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='1. General'", [$plaza, $mes, $anio]);
        DB::disconnect('dynamic');
        
        
        //Tabla 2
        $databaseName2 = 'kpimplementta';
        $connection2 = DatabaseUtils::getDynamicConnection($databaseName2);
        $tabla2Depuracion = DB::connection('dynamic')->select("select concepto, sum(cantidad) as cantidad 
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='2. Depuracion'  group by concepto", [$plaza, $mes, $anio]);

        $totalDepuracion = DB::connection('dynamic')->select("select sum(cantidad) as total 
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='2. Depuracion'", [$plaza, $mes, $anio]);
        DB::disconnect('dynamic');
        
        //Tabla 3
        $databaseName3 = 'kpimplementta';
        $connection3 = DatabaseUtils::getDynamicConnection($databaseName3);
        $tabla3Contestadas = DB::connection('dynamic')->select("
        select concepto, sum(cantidad) as cantidad from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='3. Contestadas'  group by concepto", [$plaza, $mes, $anio]);

        $totalContestadas = DB::connection('dynamic')->select("
        select sum(cantidad) as total from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='3. Contestadas'", [$plaza, $mes, $anio]);
        DB::disconnect('dynamic');
        
        //Tabla 4
        $databaseName4 = 'kpimplementta';
        $connection3 = DatabaseUtils::getDynamicConnection($databaseName4);
        $tabla4Seguimiento = DB::connection('dynamic')->select("
        select concepto, sum(cantidad) as cantidad from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='4. Seguimiento'  group by concepto", [$plaza, $mes, $anio]);

        $totalSeguimiento = DB::connection('dynamic')->select("
        select sum(cantidad) as total from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and tipo='ContactCenter' 
        and tabla ='4. Seguimiento'", [$plaza, $mes, $anio]);
        DB::disconnect('dynamic');
       
        //Nombre de la plaza 
        $nombre = extraerPrimeraPalabra($plaza);
        //Formato de fecha formateada
        $fechaFormateada = fechaReporte(0, $fechaF);
        //declaramos la variable pdf y mandamos los parametros
        $pdf = Pdf::loadView(
            'pdf.contact2',
            [
                //Tabla 1 General
                'tabla1General' => $tabla1General,
                'totalGeneral' => $totalGeneral[0]->total,
                //Tabla 2 General
                'tabla2Depuracion' => $tabla2Depuracion,
                'totalDepuracion' => $totalDepuracion[0]->total,
                //Tabla 3 Contestadas
                'tabla3Contestadas' => $tabla3Contestadas,
                'totalContestadas' => $totalContestadas[0]->total,
                //Tabla 4
                'tabla4Seguimiento' => $tabla4Seguimiento,
                'totalSeguimiento' => $totalSeguimiento[0]->total,
                //Ruta imagen
                'rutaImagen' => $rutaImagen,
                //Fecha Formateada
                'fechaFormateada' => $fechaFormateada,
                //Nombre plaza 
                'nombre' => $nombre,
                //Graficas 
                'imagenLlamadas' => $imagenLlamadas,
                'imagenDesglose' => $imagenDesglose,
                'imagenContestadas' => $imagenContestadas,
                'imagenSeguimiento' => $imagenSeguimiento,
            ]
        );
        return $pdf->stream();
    }
}
