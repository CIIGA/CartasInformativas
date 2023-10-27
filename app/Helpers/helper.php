<?php

use Carbon\Carbon;

function anio($fecha)
{
    $timestamp = strtotime($fecha);
    $anio = date('Y', $timestamp);
    return $anio;
}
function mes($fecha)
{
    $timestamp = strtotime($fecha);
    $mes = date('m', $timestamp);
    return $mes;
}
function mesLetras($mes)
{
    $meses=['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    
    return $meses[$mes-1];
}
function redondearNumero($numero, $decimales = 2)
{
    return round($numero, $decimales);
}

function extraerPrimeraPalabra($texto)
{
    // Dividimos la cadena en palabras usando el espacio como separador
    $palabras = explode(' ', $texto);

    // Obtenemos la primera palabra
    $primeraPalabra = $palabras[0];

    // Convertimos el texto completo a mayúsculas
    $textoMayusculas = strtoupper($primeraPalabra);

    return $textoMayusculas;
}
function formatoFechaInt($fecha)
{
    // Verificar si el dato proporcionado es un entero
    if (!is_double($fecha)) {
        // dd($fecha);
        return; // Si no es un entero, devolvemos nada
    }
    // Convertir el número de serie de fecha de Excel a una fecha válida
    $fechaCarbon = Carbon::createFromTimestamp((int) (($fecha - 25569) * 86400));

    // Formatear la fecha en el formato deseado (d/m/Y)
    $fechaFormateada = $fechaCarbon->format('d/m/Y');
    return $fechaFormateada;
}
function fechaReporte($fecha1, $fecha2)
{
    setlocale(LC_TIME, 'es_ES');
    if ($fecha1 == 0) {
        $diaI = 1;
    } else {
        $fecha = str_replace('/', '-', $fecha1);
        $fecha = date('Y-m-d', strtotime($fecha));
        // Obtener el día del mes
        $diaI = date('j', strtotime($fecha));
    }
    $fecha2 = str_replace('/', '-', $fecha2);
    $fecha2 = date('Y-m-d', strtotime($fecha2));
    // Obtener el día del mes
    $dia = date('j', strtotime($fecha2));


    // Nombres de los meses en español
    $meses = array(
        1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio",
        7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
    );

    // Obtener el número del mes
    $numeroMes = date('n', strtotime($fecha2));

    // Obtener el nombre del mes en español
    $mes = $meses[$numeroMes];


    // Obtener el año
    $anio = date('Y', strtotime($fecha2));

    // Formatear la fecha en el formato deseado
    $fechaFormateada = "Del {$diaI} al {$dia} de {$mes} de {$anio}";

    return $fechaFormateada;
}
