<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DatabaseUtils;
use App\Models\Plaza;
use Illuminate\Support\Facades\DB;


class IndexController extends Controller
{

    public function index()
    {
        $databaseName1 = 'kpis';
        $connection1 = DatabaseUtils::getDynamicConnection($databaseName1);
        $plazas = DB::connection('dynamic')->select("SELECT [id_proveniente] as id,
        [nombreProveniente] as plaza ,[data] as bd FROM [implementtaAdministrator].[dbo].[proveniente]  
        WHERE [nombreProveniente] <> 'Implementta Demo';");
        DB::disconnect('dynamic');
        // $databaseName2= 'kpimplementta';
        // $connection2 = DatabaseUtils::getDynamicConnection($databaseName2);
        // $historico = DB::connection('dynamic')->select("select fecha_enviado from historicoCampaniaCorreo 
        // group by fecha_enviado order by fecha_enviado desc");
        // DB::disconnect('dynamic');
        return view('index', ['plazas' => $plazas]);
    }
   
}
