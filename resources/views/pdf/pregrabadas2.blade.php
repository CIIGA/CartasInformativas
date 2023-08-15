<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pregrabada</title>
    <link href="C:/wamp64/www/CartasInformativas/public/css/pdf.css" rel="stylesheet">
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
        <img class="imgHeader1" src="{{ public_path('storage/img/plazas/default.jpg') }}">
        <p class="infoHeader">
            <span class="bold">
                Informe de Programa:
            </span>
            <br />
            Pregrabadas
        </p>
        <img class="imgHeader2" src="{{ public_path($rutaImagen) }}">
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
                    <td>{{$tabla1Pregrabada[0]->concepto}}</td>
                    <td>{{$tabla1Pregrabada[0]->cantidad}}</td>
                    <td>{{$result1}}</td>
                </tr>
                <tr>
                    <td>{{$tabla1Pregrabada[1]->concepto}}</td>
                    <td>{{$tabla1Pregrabada[1]->cantidad}}</td>
                    <td>{{$result2}}</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>{{$total1}}</td>
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
                <tr>
                    <td>{{$tabla2Pregrabada[0]->concepto}}</td>
                    <td>{{$tabla2Pregrabada[0]->cantidad}}</td>
                    <td>{{$result11}}</td>
                </tr>
                <tr>
                    <td>{{$tabla2Pregrabada[1]->concepto}}</td>
                    <td>{{$tabla2Pregrabada[1]->cantidad}}</td>
                    <td>{{$result22}}</td>
                </tr>
                <tr>
                    <td>{{$tabla2Pregrabada[2]->concepto}}</td>
                    <td>{{$tabla2Pregrabada[2]->cantidad}}</td>
                    <td>{{$result33}}</td>
                </tr>
                <tr>
                    <td>{{$tabla2Pregrabada[3]->concepto}}</td>
                    <td>{{$tabla2Pregrabada[3]->cantidad}}</td>
                    <td>{{$result44}}</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>{{$total22}}</td>
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