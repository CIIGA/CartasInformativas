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
        if ($exec[0]->resultado == 1) {
            // return $this->pdfPregabadas($idPlaza, $plaza, $fechaF);
            $anio = anio($fechaF);
            $mes = mes($fechaF);
            $databaseName3 = 'kpimplementta';
            $connection3 = DatabaseUtils::getDynamicConnection($databaseName3);
            $tabla1Pregrabada = DB::connection('dynamic')->select("select sum(cantidad) as c
            from [kpimplementta].[dbo].[profile_operation_t25] where 
            plaza = ? and numero = ? and año = ? and 
            tipo='Pregrabadas' and tabla ='1. General'", [$plaza, $mes, $anio]);
            DB::disconnect('dynamic');

            if ($tabla1Pregrabada[0]->c == null) {
                return back()->with('error', 'No hay información en este rango de fechas.');
            } else {
                if ($tabla1Pregrabada[0]->c != 0) {
                    return '<script type="text/javascript">window.open("pdfPregabadas/' . $idPlaza . '/' . $plaza . '/' . $fechaF . '")</script>' .
                        redirect()->action(
                            [IndexController::class, 'index']
                        );
                } else {
                    return back()->with('error', 'No hay pregrabadas validas en este rango de fechas.');
                }
            }
        } else {
            return back()->with('error', 'Error al ejecutar el proceso, intente de nuevo y si el problema persiste comuniquese con soporte');
        }
    }
    public function pdfPregabadas($idPlaza, $plaza, $fechaF)
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
        //Tabla 1 
        $anio = anio($fechaF);
        $mes = mes($fechaF);
        $databaseName1 = 'kpimplementta';
        $connection1 = DatabaseUtils::getDynamicConnection($databaseName1);
        $tabla1Pregrabada = DB::connection('dynamic')->select("select concepto, sum(cantidad) as cantidad  
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and 
        tipo='Pregrabadas' and tabla ='1. General' group by concepto", [$plaza, $mes, $anio]);

        $totalGeneral = DB::connection('dynamic')->select("select sum(cantidad) as total
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and 
        tipo='Pregrabadas' and tabla ='1. General'", [$plaza, $mes, $anio]);
        
        $general=0;
        foreach ($tabla1Pregrabada as $item) {
            $general++;
        }
        //Tabla 2
        $tabla2Pregrabada = DB::connection('dynamic')->select("select concepto, sum(cantidad) as cantidad  
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero =? and año = ? and 
        tipo='Pregrabadas' and tabla ='2. Desglose' group by concepto", [$plaza, $mes, $anio]);

        $totalDesglose = DB::connection('dynamic')->select("select sum(cantidad) as total  
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero =? and año = ? and 
        tipo='Pregrabadas' and tabla ='2. Desglose'", [$plaza, $mes, $anio]);
        
        $Desglose=0;
        foreach ($tabla2Pregrabada as $item) {
            $Desglose++;
        }

        DB::disconnect('dynamic');
        
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
                'totalGeneral' => $totalGeneral[0]->total,
                'general' => $general,
                'totalDesglose' => $totalDesglose[0]->total,
                'Desglose' => $Desglose,
                
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
        $fechaF = $request->fechaF;
        $plaza = $request->plaza;
        $idPlaza = $request->idPlaza;
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
        //Tabla 1 
        $anio = anio($fechaF);
        $mes = mes($fechaF);
        $databaseName1 = 'kpimplementta';
        $connection1 = DatabaseUtils::getDynamicConnection($databaseName1);
        $tabla1Pregrabada = DB::connection('dynamic')->select("select concepto, sum(cantidad) as cantidad  
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and 
        tipo='Pregrabadas' and tabla ='1. General' group by concepto", [$plaza, $mes, $anio]);

        $totalGeneral = DB::connection('dynamic')->select("select sum(cantidad) as total
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero = ? and año = ? and 
        tipo='Pregrabadas' and tabla ='1. General'", [$plaza, $mes, $anio]);
        DB::disconnect('dynamic');
       
        
        //Tabla 2
        $tabla2Pregrabada = DB::connection('dynamic')->select("select concepto, sum(cantidad) as cantidad  
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero =? and año = ? and 
        tipo='Pregrabadas' and tabla ='2. Desglose' group by concepto", [$plaza, $mes, $anio]);

        $totalDesglose = DB::connection('dynamic')->select("select sum(cantidad) as total  
        from [kpimplementta].[dbo].[profile_operation_t25] where 
        plaza = ? and numero =? and año = ? and 
        tipo='Pregrabadas' and tabla ='2. Desglose'", [$plaza, $mes, $anio]);
        DB::disconnect('dynamic');
      
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
                'totalGeneral' => $totalGeneral[0]->total,
                'totalDesglose' => $totalDesglose[0]->total,
                'rutaImagen' => $rutaImagen,
                //Nombre plaza 
                'nombre' => $nombre,
                //Fecha Formateada
                'fechaFormateada' => $fechaFormateada,
                'imagenSeguimiento' => $imagenSeguimiento,
                'imagenContestadas' => $imagenContestadas,
            ]
        );
        return $pdf->stream();
    }
}
