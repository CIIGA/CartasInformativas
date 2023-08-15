<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Correo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
</head>

<body>
    <div>
        <header>
            <img class="imgHeader1" src="{{ asset('storage/img/plazas/default.jpg') }}">
            <p class="infoHeader">
                <span class="bold">
                    Informe de Programa:
                </span>
                <br />
                Correos Electronicos
            </p>
            <img class="imgHeader2" src="{{ asset($rutaImagen) }}">
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
            <div id="piechart" style="width: 500px; height: 300px;"></div>
        </main>
    </div>
    <div align="center">
        <form method="post" action="{{ route('GenerarPDFCorreo') }}">
            @csrf
            <input type="hidden" id="imagen" name="imagen"  />
            <input type="hidden" id="fecha" name="fecha" value="{{$fecha}}"  />
            <input type="hidden" id="idPlaza" name="idPlaza" value="{{$idPlaza}}" />
            <button type="submit" id="create_pdf" class="btn btn-success">Generar PDF</button>
        </form>
    </div>
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
                    colors: ['#A5A5A5', '#457ABF'] // Personalizar los colores aquí
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
                 // Obtener la URL de la imagen generada
                var imageUrl = chart.getImageURI();
               // Obtén una referencia a la imagen por su id
                var imagen = document.getElementById('imagen');
                // Asigna un valor a la imagen
                imagen.value = imageUrl;
            }
        }

        // Llamar a la función generadora de gráficos
        var etiquetas = ['Correos rebotado', 'Correos Recibido'];
        var valores = [{{$result2}}, {{$result1}}];
        generatePieChart(etiquetas, valores,'Campaña de correos masivos');
    </script>
</body>

</html>