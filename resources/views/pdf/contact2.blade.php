<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>CartaContact_{{$plaza}}_{{$mes.$anio}}</title>
    {{-- <link href="C:/wamp64/www/CartasInformativas/public/css/pdf.css" rel="stylesheet"> --}}
    <link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/implementta/modulos/CartasInformativas/public/css/pdf.css" rel="stylesheet"> 

    
   
    <style>
        .row {
            position: static;
            margin-bottom: 0px;
            margin-top: 0px;
            height: 195px;
        }

        img {
            margin-bottom: 0px;
            width: 370px;
            height: 200px;
            position: absolute;
            right: 0px;
        }

        .image {
            top: -130px;
            position: relative;
            margin-bottom: 0px;
            margin-right: -20px
          
        }

        th {
            font-weight: normal;
            font-size: 15px;
            background-color: black;
            color: white;
        }

        td {
            min-width: 50px;
            max-width: 100px;
            font-weight: normal;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <header>
        <img class="imgHeader1" src="{{ public_path('img/plazas/default.jpg') }}">
        <p class="infoHeader">
            <span class="bold">
                Informe de Programa:
            </span>
            <br />
            Contact Center
        </p>
        <img class="imgHeader2" src="{{ $rutaImagen }}">
    </header>
    <main>
        <p class="align-right mr-20">
            <span class="bold">
                Asunto:
            </span>
            Notificacion de adeudo en su cuenta de agua
        </p>
        <p class="bold">
            COMISIÓN ESTATAL DE SERVICIOS PÚBLICOS DE {{$nombre}}
        </p>
        <p>
            <span class="bold">
                Periodo:
            </span>
            {{$fechaFormateada}}
        </p>
        <p>
            <span class="bold">
                Tipo de campaña:
            </span>
            Extrajudicial "Invitación a pagar adeudo de agua"
        </p>
        <br />
        <div class="row">
            <table>
                <tbody>
                    <tr>
                        <th colspan="3">Efectividad de Llamadas</th>
                    </tr>
                    @foreach ($tabla1General as $item)
                    <tr>
                        <td>{{ $item->concepto }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>{{ round(($item->cantidad / $totalGeneral) * 100, 2) }}%</td>
                    </tr>
                @endforeach
                    <tr>
                        <td>Total</td>
                        <td>{{$totalGeneral}}</td>
                        <td>100</td>
                    </tr>
                </tbody>
            </table>
            <div class="image">
                <img src="{{$imagenLlamadas}}">
            </div>
        </div>
        <br />
        <div class="row">
            <table>
                <tbody>
                    <tr>
                        <th colspan="3">Desglose llamadas depuradas</th>
                    </tr>
                    @foreach ($tabla2Depuracion as $item)
                    <tr>
                        <td>{{ $item->concepto }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>{{ round(($item->cantidad / $totalDepuracion) * 100, 2) }}%</td>
                    </tr>
                @endforeach
                    <tr>
                        <td>Total</td>
                        <td>{{$totalDepuracion}}</td>
                        <td>100%</td>
                    </tr>
                </tbody>
            </table>
            <div class="image" style="margin-top: -10px">
                <img src="{{$imagenDesglose}}">
            </div>
        </div>
        <br />
        <div class="row" style="margin-top: -47px">
            <table>
                <tbody>
                    <tr>
                        <th colspan="3">Desglose llamadas Contestadas</th>
                    </tr>
                    @foreach ($tabla3Contestadas as $item)
                        <tr>
                            <td>{{ $item->concepto }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td>{{ round(($item->cantidad / $totalContestadas) * 100, 2) }}%</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>Total</td>
                        <td>{{$totalContestadas}}</td>
                        <td>100%</td>
                    </tr>
                </tbody>
            </table>
            <div class="image" style="margin-top: -10px">
                <img src="{{$imagenContestadas}}">
            </div>
        </div>
        <br />
        <div class="row" style="margin-top: 20px">
            <table>
                <tbody>
                    <tr>
                        <th colspan="3">Desglose seguimiento de llamada</th>
                    </tr>
                    @foreach ($tabla4Seguimiento as $item)
                    <tr>
                        <td>{{ $item->concepto }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>{{ round(($item->cantidad / $totalSeguimiento) * 100, 2) }}%</td>
                    </tr>
                @endforeach
                    <tr>
                        <td>Total</td>
                        <td>{{$totalSeguimiento}}</td>
                        <td>100%</td>
                    </tr>
                </tbody>
            </table>
            <div class="image">
                <img src="{{$imagenSeguimiento}}">
            </div>
        </div>
    </main>

</body>

</html>