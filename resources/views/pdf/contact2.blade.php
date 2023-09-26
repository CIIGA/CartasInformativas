<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ContactCenter</title>
    <link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/implementta/modulos/CartasInformativas/public/css/pdf.css" rel="stylesheet">
    <style>
        .row {
            position: static;
            margin-bottom: 5px;
            margin-top: 5px;
        }

        img {
            margin-bottom: 15px;
            width: 320px;
            height: 150px;
            position: absolute;
            right: 0px;
        }

        .image {
            top: -150px;
            position: relative;
            margin-bottom: 35px;
          
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
                    <tr>
                        <td>{{$tabla1General[0]->concepto}}</td>
                        <td>{{$tabla1General[0]->cantidad}}</td>
                        <td>{{$result1General}}%</td>
                    </tr>
                    <tr>
                        <td>{{$tabla1General[1]->concepto}}</td>
                        <td>{{$tabla1General[1]->cantidad}}</td>
                        <td>{{$result2General}}%</td>
                    </tr>
                    <tr>
                        <td>{{$tabla1General[2]->concepto}}</td>
                        <td>{{$tabla1General[2]->cantidad}}</td>
                        <td>{{$result3General}}%</td>
                    </tr>
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
                    <tr>
                        <td>{{$tabla2Depuracion[0]->concepto}}</td>
                        <td>{{$tabla2Depuracion[0]->cantidad}}</td>
                        <td>{{$result1Depuracion}}%</td>
                    </tr>
                    <tr>
                        <td>{{$tabla2Depuracion[1]->concepto}}</td>
                        <td>{{$tabla2Depuracion[1]->cantidad}}</td>
                        <td>{{$result2Depuracion}}%</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>{{$totalDepuracion}}</td>
                        <td>100%</td>
                    </tr>
                </tbody>
            </table>
            <div class="image">
                <img src="{{$imagenDesglose}}">
            </div>
        </div>
        <br />
        <div class="row">
            <table>
                <tbody>
                    <tr>
                        <th colspan="3">Desglose llamadas Contestadas</th>
                    </tr>
                    <tr>
                        <td>{{$tabla3Contestadas[0]->concepto}}</td>
                        <td>{{$tabla3Contestadas[0]->cantidad}}</td>
                        <td>{{$result1Contestadas}}%</td>
                    </tr>
                    <tr>
                        <td>{{$tabla3Contestadas[1]->concepto}}</td>
                        <td>{{$tabla3Contestadas[1]->cantidad}}</td>
                        <td>{{$result2Contestadas}}%</td>
                    </tr>
                    <tr>
                        <td>{{$tabla3Contestadas[2]->concepto}}</td>
                        <td>{{$tabla3Contestadas[2]->cantidad}}</td>
                        <td>{{$result3Contestadas}}%</td>
                    </tr>
                    <tr>
                        <td>{{$tabla3Contestadas[3]->concepto}}</td>
                        <td>{{$tabla3Contestadas[3]->cantidad}}</td>
                        <td>{{$result4Contestadas}}%</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>{{$totalContestadas}}</td>
                        <td>100%</td>
                    </tr>
                </tbody>
            </table>
            <div class="image">
                <img src="{{$imagenContestadas}}">
            </div>
        </div>
        <br />
        <div class="row">
            <table>
                <tbody>
                    <tr>
                        <th colspan="3">Desglose seguimiento de llamada</th>
                    </tr>
                    <tr>
                        <td>{{$tabla4Seguimiento[0]->concepto}}</td>
                        <td>{{$tabla4Seguimiento[0]->cantidad}}</td>
                        <td>{{$result1Seguimiento}}%</td>
                    </tr>
                    <tr>
                        <td>{{$tabla4Seguimiento[1]->concepto}}</td>
                        <td>{{$tabla4Seguimiento[1]->cantidad}}</td>
                        <td>{{$result2Seguimiento}}%</td>
                    </tr>
                    <tr>
                        <td>{{$tabla4Seguimiento[2]->concepto}}</td>
                        <td>{{$tabla4Seguimiento[2]->cantidad}}</td>
                        <td>{{$result3Seguimiento}}%</td>
                    </tr>
                    <tr>
                        <td>{{$tabla4Seguimiento[3]->concepto}}</td>
                        <td>{{$tabla4Seguimiento[3]->cantidad}}</td>
                        <td>{{$result4Seguimiento}}%</td>
                    </tr>
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