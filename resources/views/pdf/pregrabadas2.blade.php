<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<<<<<<< HEAD
    <title>Pregrabada</title>
    <!-- <link href="C:/wamp64/www/CartasInformativas/public/css/pdf.css" rel="stylesheet"> -->
    <link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/implementta/modulos/CartasInformativas/public/css/pdf.css" rel="stylesheet">
=======
    <title>Pregrabadas_{{$plaza}}_{{$mes.$anio}}</title>
    <link href="C:/wamp64/www/CartasInformativas/public/css/pdf.css" rel="stylesheet">
    {{-- <link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/implementta/modulos/CartasInformativas/public/css/pdf.css" rel="stylesheet">Toluca Predial --}}
>>>>>>> 5f41e56c320739948ba167db2b3ea7b68799667a
    <style>
        .row {
            position: relative;
            margin-bottom: 150px;

        }

        .img1 {
            top: 0px;
            position: absolute;
            left: -50px;
            width: 320px;
            height: 150px;
        }
        .img2 {
            top: 0px;
            position: absolute;
            right: 0px;
            height: 150px;
            width: 320px;
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
            Pregrabadas
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
        <table>
            <tbody>
                <tr>
                    <th colspan="3">Desglose llamadas Contestadas</th>
                </tr>
                <tr>
                    <td>Etiqueta</td>
                    <td>Cantidad</td>
                    <td>%</td>
                </tr>
                <tr>
                    @foreach ($tabla1Pregrabada as $item)
                    <tr>
                        <td>{{ $item->concepto }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>{{ round(($item->cantidad / $totalGeneral) * 100,2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>Total</td>
                    <td>{{ $totalGeneral }}</td>
                    <td>100</td>
                </tr>
            </tbody>
        </table>
        <br />
        <table>
            <tbody>
                <tr>
                    <th colspan="3">Desglose seguimiento de llamada</th>
                </tr>
                <tr>
                    <td>Etiqueta</td>
                    <td>Cantidad</td>
                    <td>%</td>
                </tr>
                @foreach ($tabla2Pregrabada as $item)
                <tr>
                    <td>{{ $item->concepto }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ round(($item->cantidad / $totalDesglose) * 100,2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td>Total</td>
                <td>{{ $totalDesglose }}</td>
                <td>100</td>
            </tr>
            </tbody>
        </table>
        <br />
        <div class="row">
            <img class="img1" src="{{$imagenSeguimiento}}">
            <img class="img2" src="{{$imagenContestadas}}">
        </div>
        <br />
        <div>
            <p>
                NOTA:
                <br />
                1.No hubo horario determinado para el envío de las pregrabadas
                <br />
                2.La categoría Número desconectado automático (ADC) incluye las subcategorías: DROP, PDROP, LRERR
                <br />
                3.La categoría Desviada o transferida a buzón incluye las subcategorías: NA, XFER, NI.
            </p>
        </div>
    </main>

</body>

</html>