<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pregrabada</title>
    {{--
    <link href="C:/wamp64/www/CartasInformativas/public/css/pdf.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style>
        .row {
            display: flex;
        }
    </style>
</head>

<body>
    <header>
        <img class="imgHeader1" src="{{ asset('img/plazas/default.jpg') }}">
        <p class="infoHeader">
            <span class="bold">
                Informe de Programa:
            </span>
            <br />
            Pregrabadas
        </p>
        <img class="imgHeader2" src="{{ asset('img/plazas/'.$rutaImagen.'.jpg') }}">
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
            <div id="piechart" style="width: 400px; height: 200px;"></div>
            <div id="piechart2" style="width: 400px; height: 200px;"></div>
        </div>
        <div>
                NOTA:
                <br/>
                1.No hubo horario determinado para el envío de las pregrabadas
                <br/>
                2.La categoría Número desconectado automático (ADC) incluye las subcategorías: DROP, PDROP, LRERR
                <br/>
                3.La categoría Desviada o transferida a buzón incluye las subcategorías: NA, XFER, NI.
        </div>
    </main>
    <div align="center">
        <form method="post" action="{{ route('GenerarPDFPregrabada') }}">
            @csrf
            <input type="hidden" id="imagenContestadas" name="imagenContestadas" />
            <input type="hidden" id="imagenSeguimiento" name="imagenSeguimiento" />
            <input type="hidden" id="fechaF" name="fechaF" value="{{$fechaF}}" />
            <input type="hidden" id="plaza" name="plaza" value="{{$plaza}}" />
            <input type="hidden" id="idPlaza" name="idPlaza" value="{{$idPlaza}}" />
            <button type="submit" id="create_pdf" class="btn btn-success">Generar PDF</button>
        </form>
    </div>
    {{-- Llamadas contestadas --}}
    <script type="text/javascript">
        function generatePieChart(labels, values,title) {
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Label');
            data.addColumn('number', 'Value');
            for (var i = 0; i < labels.length; i++) {
                data.addRow([labels[i], values[i]]);
            }

            var options = {
                title: title,
                pieHole: 0.4,
                chartArea: { left: 100, top: 70, width: '100%', height: '80%' },
                colors: ['#264478','#80B2DF'] // Personalizar los colores aquí
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
             // Obtener la URL de la imagen generada
            var imageUrl = chart.getImageURI();
           // Obtén una referencia a la imagen por su id
            var imagen = document.getElementById('imagenContestadas');
            // Asigna un valor a la imagen
            imagen.value = imageUrl;
        }
    }

    // Llamar a la función generadora de gráficos
    var etiquetas = ['{{$tabla1Pregrabada[0]->concepto}}',' {{$tabla1Pregrabada[1]->concepto}}'];
    var valores = [{{$result1}}, {{$result2}}];
    generatePieChart(etiquetas, valores,'Realizadas');
    </script>
    {{-- Desglose de seguimiento de llamada --}}
    <script type="text/javascript">
        function generatePieChart(labels, values,title) {
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Label');
            data.addColumn('number', 'Value');
            for (var i = 0; i < labels.length; i++) {
                data.addRow([labels[i], values[i]]);
            }

            var options = {
                title: title,
                pieHole: 0.4,
                chartArea: { left: 100, top: 70, width: '100%', height: '80%' },
                colors: ['#F27B35','#FFC000','#76A646','#4472C4'] // Personalizar los colores aquí
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
            chart.draw(data, options);
             // Obtener la URL de la imagen generada
            var imageUrl = chart.getImageURI();
           // Obtén una referencia a la imagen por su id
            var imagen = document.getElementById('imagenSeguimiento');
            // Asigna un valor a la imagen
            imagen.value = imageUrl;
        }
    }

    // Llamar a la función generadora de gráficos
    var etiquetas = ['{{$tabla2Pregrabada[0]->concepto}}',' {{$tabla2Pregrabada[1]->concepto}}','{{$tabla2Pregrabada[2]->concepto}}','{{$tabla2Pregrabada[3]->concepto}}'];
    var valores = [{{$result11}}, {{$result22}},{{$result33}},{{$result44}}];
    generatePieChart(etiquetas, valores,'No exitosas');
    </script>
</body>

</html>