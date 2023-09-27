<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Correo</title>
    <link href="C:/wamp64/www/CartasInformativas/public/css/pdf.css" rel="stylesheet">
    {{-- <link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/implementta/modulos/CartasInformativas/public/css/pdf.css" rel="stylesheet"> --}}
</head>

<body>
    <div>
        <header>
            <img class="imgHeader1" src="{{ public_path('img/plazas/default.jpg') }}">
            <p class="infoHeader">
                <span class="bold">
                    Informe de Programa:
                </span>
                <br />
                Correos Electronicos
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
                        <th colspan="3">Campaña de Correos Enviados</th>
                    </tr>
                    <tr>
                        <td>Global Correos Enviados </td>
                        <td>{{$total}} </td>
                        <td>100%</td>
                    </tr>
                </tbody>
            </table>
            <br />
            <table>
                <tbody>
                    <tr>
                        <th colspan="3">Desglose de campaña de Correos</th>
                    </tr>
                    <tr>
                        <td>Correos rebotados</td>
                        <td>{{$nulos}}</td>
                        <td>{{$result2}}</td>
                    </tr>
                    <tr>
                        <td>Correos Recibidos</td>
                        <td>{{$enviados}}</td>
                        <td>{{$result1}}</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>{{$total}}</td>
                        <td>100</td>
                    </tr>
                </tbody>
            </table>
            <br />
            <img src="{{$imagen}}">
        </main>
    </div>
</body>
</html>