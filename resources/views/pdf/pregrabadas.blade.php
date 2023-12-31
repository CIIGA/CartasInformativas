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
        <img class="imgHeader2" src="{{ asset('img/plazas/' . $rutaImagen . '.jpg') }}">
    </header>
    <main>
        <p class="align-right mr-20">
            <span class="bold">
                Asunto:
            </span>
            Notificacion de adeudo en su cuenta de agua
        </p>
        <p class="bold">
            COMISIÓN ESTATAL DE SERVICIOS PÚBLICOS DE {{ $nombre }}
        </p>
        <p>
            <span class="bold">
                Periodo:
            </span>
            {{ $fechaFormateada }}
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

                @foreach ($tabla1Pregrabada as $item)
                    <tr>
                        <td>{{ $item->concepto }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>{{ round(($item->cantidad / $totalGeneral) * 100, 2) }}</td>
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
                        <td>{{ round(($item->cantidad / $totalDesglose) * 100, 2) }}</td>
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
            <div id="piechart" style="width: 500px; height: 300px;"></div>
            <div id="piechart2" style="width: 500px; height: 300px;"></div>
        </div>
        <div>
            NOTA:
            <br />
            1.No hubo horario determinado para el envío de las pregrabadas
            <br />
            2.La categoría Número desconectado automático (ADC) incluye las subcategorías: DROP, PDROP, LRERR
            <br />
            3.La categoría Desviada o transferida a buzón incluye las subcategorías: NA, XFER, NI.
        </div>
    </main>
    <div align="center">
        <form method="post" action="{{ route('GenerarPDFPregrabada') }}">
            @csrf
            <input type="hidden" id="imagenContestadas" name="imagenContestadas" />
            <input type="hidden" id="imagenSeguimiento" name="imagenSeguimiento" />
            <input type="hidden" id="fechaF" name="fechaF" value="{{ $fechaF }}" />
            <input type="hidden" id="plaza" name="plaza" value="{{ $plaza }}" />
            <input type="hidden" id="idPlaza" name="idPlaza" value="{{ $idPlaza }}" />
            <button type="submit" id="create_pdf" class="btn btn-success">Generar PDF</button>
        </form>
    </div>
    {{-- Llamadas contestadas --}}
    <script type="text/javascript">
        
        function generatePieChart(labels, values, title) {
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Element');
                data.addColumn('number', 'Percentage');
                total=0;
                for (var j = 0; j < labels.length; j++) {
                    total+=values[j];
                }
                for (var i = 0; i < labels.length; i++) {
                    data.addRow([labels[i] + ' '+parseFloat(((values[i]/total)*100).toFixed(2)) + '%', values[i]]);
                }

                var options = {
                    title: title,
                    chartArea: {
                        left: 100,
                        top: 70,
                        width: '500',
                        height: '300',
                    },

                    colors: ['#264478', '#80B2DF'], // Personalizar los colores aquí
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


        var etiquetas = [];
        var tabla1Pregrabada = @json($tabla1Pregrabada); // Convierte el array PHP en un objeto JavaScript
        @for ($i = 0; $i < $general; $i++)
            etiquetas.push('{{ $tabla1Pregrabada[$i]->concepto }}');
        @endfor

        var valores = [];
        @for ($i = 0; $i < $general; $i++)
            valores.push({{ ($tabla1Pregrabada[$i]->cantidad / $totalGeneral) * 100 }});
        @endfor
        generatePieChart(etiquetas, valores, 'Realizadas');
    </script>
    {{-- Desglose de seguimiento de llamada --}}
    <script type="text/javascript">
        function generatePieChart(labels, values, title) {
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Element');
                data.addColumn('number', 'Percentage');
                total=0;
                for (var j = 0; j < labels.length; j++) {
                    total+=values[j];
                }
                for (var i = 0; i < labels.length; i++) {
                    data.addRow([labels[i] + ' '+parseFloat(((values[i]/total)*100).toFixed(2)) + '%', values[i]]);
                }

                var options = {
                    title: title,
                    chartArea: {
                        left: 100,
                        top: 70,
                        width: '500',
                        height: '300',
                    },

                    colors: ['#F27B35', '#FFC000', '#76A646', '#4472C4'], // Personalizar los colores aquí
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


        // Resto del código para obtener etiquetas y valores


        var etiquetas = [];
        var tabla2Pregrabada = @json($tabla2Pregrabada); // Convierte el array PHP en un objeto JavaScript
        @for ($i = 0; $i < $Desglose; $i++)
            etiquetas.push('{{ $tabla2Pregrabada[$i]->concepto }}');
        @endfor
        var valores = [];
        @for ($i = 0; $i < $Desglose; $i++)
            valores.push({{ ($tabla2Pregrabada[$i]->cantidad / $totalGeneral) * 100 }});
        @endfor

        generatePieChart(etiquetas, valores, 'No exitosas');
    </script>
</body>

</html>
