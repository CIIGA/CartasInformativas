<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ContactCenter</title>
    {{--
    <link href="C:/wamp64/www/CartasInformativas/public/css/pdf.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <style>
        main {
            display: flex;
        }

        .column_1 {
            width: 50%;
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
            Contact Center
        </p>
        <img class="imgHeader2" src="{{ asset('img/plazas/'.$rutaImagen.'.jpg') }}">
    </header>
    <main>
        <div class="column_1">
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
                        <th colspan="3">Efectividad de Llamadas</th>
                    </tr>
                    <tr>
                        <td>{{$tabla1General[0]->concepto}}</td>
                        <td>{{$tabla1General[0]->cantidad}}</td>
                        <td>{{$result1General}}</td>
                    </tr>
                    <tr>
                        <td>{{$tabla1General[1]->concepto}}</td>
                        <td>{{$tabla1General[1]->cantidad}}</td>
                        <td>{{$result2General}}</td>
                    </tr>
                    <tr>
                        <td>{{$tabla1General[2]->concepto}}</td>
                        <td>{{$tabla1General[2]->cantidad}}</td>
                        <td>{{$result3General}}</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>{{$totalGeneral}}</td>
                        <td>100</td>
                    </tr>
                </tbody>
            </table>
            <br />
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
            <br />
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
            <br />
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
            <br />
        </div>
        <div>
            <div id="piechart" style="width: 400px; height: 200px;"></div>
            <div id="piechart2" style="width: 400px; height: 200px;"></div>
            <div id="piechart3" style="width: 400px; height: 200px;"></div>
            <div id="piechart4" style="width: 400px; height: 200px;"></div>
        </div>
    </main>
    <div align="center">
        <form method="post"  action="{{ route('GenerarPDFContact') }}">
            @csrf
            <input type="hidden" id="imagenLlamadas" name="imagenLlamadas" />
            <input type="hidden" id="imagenDesglose" name="imagenDesglose" />
            <input type="hidden" id="imagenContestadas" name="imagenContestadas" />
            <input type="hidden" id="imagenSeguimiento" name="imagenSeguimiento" />
            <input type="hidden" id="fechaF" name="fechaF" value="{{$fechaF}}" />
            <input type="hidden" id="plaza" name="plaza" value="{{$plaza}}" />
            <input type="hidden" id="idPlaza" name="idPlaza" value="{{$idPlaza}}" />
            <button type="submit" id="create_pdf" class="btn btn-success">Generar PDF</button>
        </form>
    </div>
    {{-- Efectividad de llamadas --}}
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
                    colors: ['#76A646', '#457ABF','#F29F05'] // Personalizar los colores aquí
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
                 // Obtener la URL de la imagen generada
                var imageUrl = chart.getImageURI();
               // Obtén una referencia a la imagen por su id
                var imagen = document.getElementById('imagenLlamadas');
                // Asigna un valor a la imagen
                imagen.value = imageUrl;
            }
        }

        // Llamar a la función generadora de gráficos
        var etiquetas = ['{{$tabla1General[0]->concepto}}',' {{$tabla1General[1]->concepto}}','{{$tabla1General[2]->concepto}}'];
        var valores = [{{$result1General}}, {{$result2General}},{{$result3General}}];
        generatePieChart(etiquetas, valores,'Efectividad de llamadas');
    </script>
    {{-- Desglose de llamadas depuradas --}}
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
                    colors: ['#457ABF','#F27B35'] // Personalizar los colores aquí
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
                chart.draw(data, options);
                 // Obtener la URL de la imagen generada
                var imageUrl = chart.getImageURI();
               // Obtén una referencia a la imagen por su id
                var imagen = document.getElementById('imagenDesglose');
                // Asigna un valor a la imagen
                imagen.value = imageUrl;
            }
        }

        // Llamar a la función generadora de gráficos
        var etiquetas = ['{{$tabla2Depuracion[0]->concepto}}',' {{$tabla2Depuracion[1]->concepto}}'];
        var valores = [{{$result1Depuracion}}, {{$result2Depuracion}}];
        generatePieChart(etiquetas, valores,'Desglose llamadas depuradas');
    </script>
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
                    colors: ['#80B2DF','#264478','#4875C5','#A5A5A5'] // Personalizar los colores aquí
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart3'));
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
        var etiquetas = ['{{$tabla3Contestadas[0]->concepto}}',' {{$tabla3Contestadas[1]->concepto}}','{{$tabla3Contestadas[2]->concepto}}','{{$tabla3Contestadas[3]->concepto}}'];
        var valores = [{{$result1Contestadas}}, {{$result2Contestadas}},{{$result3Contestadas}},{{$result4Contestadas}}];
        generatePieChart(etiquetas, valores,'Desglose llamadas contestadas');
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
                    colors: ['#5B9BD5','#70AD47','#43682B','#FFC000'] // Personalizar los colores aquí
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart4'));
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
        var etiquetas = ['{{$tabla4Seguimiento[0]->concepto}}',' {{$tabla4Seguimiento[1]->concepto}}','{{$tabla4Seguimiento[2]->concepto}}','{{$tabla4Seguimiento[3]->concepto}}'];
        var valores = [{{$result1Seguimiento}}, {{$result2Seguimiento}},{{$result3Seguimiento}},{{$result4Seguimiento}}];
        generatePieChart(etiquetas, valores,'Desglose seguimiento de llamada');
    </script>
</body>

</html>