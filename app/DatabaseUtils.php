<?php
namespace App;

use Illuminate\Support\Facades\DB;

class DatabaseUtils
{
    public static function getDynamicConnection($databaseName)
    {
        $connectionInfo = [
            'driver' => 'sqlsrv',
            'host' => '51.222.44.135',
            'port' => 1433,
            'database' => $databaseName,
            'username' => 'sa',
            'password' => 'vrSxHH3TdC',
            // Otras configuraciones si es necesario (charset, collation, etc.)
        ];

        // Configurar la conexión usando Eloquent de Laravel
        config(['database.connections.dynamic' => $connectionInfo]);

        $connection = DB::connection('dynamic');

        // Puedes establecer el timezone aquí si es necesario
        // date_default_timezone_set('America/Mexico_City');

        return $connection;
    }
}