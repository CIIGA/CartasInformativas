 // Variable para almacenar la página actual
 var paginaActual = 1;

 // Función para construir la tabla con los datos recibidos
 function construirTabla(data) {
     var tablaHtml = '<table class="table">';
     tablaHtml += '<thead><tr><th>Cuenta</th><th>Fecha Enviado</th><th>Fecha Leido</th></tr></thead>';
     $.each(data.data, function(index, row) {
         tablaHtml += '<tr>';
         tablaHtml += '<td>' + row.cuenta + '</td>';
         tablaHtml += '<td>' + row.fecha_enviado + '</td>';
         tablaHtml += '<td>' + row.fecha_leido + '</td>';
         tablaHtml += '</tr>';
     });
     tablaHtml += '</table>';

     // Mostrar la tabla en el div 'tablaHistorico'
     $('#tablaHistorico').html(tablaHtml);
 }

 // Función para manejar la paginación de la tabla
 function manejarPaginacion(data) {
     var pagination = '<ul class="pagination">';
     if (data.prev_page_url) {
         pagination += '<li class="page-item"><a class="page-link" href="#" onclick="cargarPagina(' + (paginaActual - 1) + ')">Anterior</a></li>';
     }
     if (data.next_page_url) {
         pagination += '<li class="page-item"><a class="page-link" href="#" onclick="cargarPagina(' + (paginaActual + 1) + ')">Siguiente</a></li>';
     }
     pagination += '</ul>';

     // Mostrar la paginación debajo de la tabla
     $('#tablaContenedor').append(pagination);
 }

 // Función para cargar una página específica mediante AJAX y actualizar la tabla y la paginación
 function cargarPagina(pagina) {
     $.ajax({
         url: "{{ route('obtenerDatosTabla') }}",
         method: 'GET',
         data: { fecha: $('#fechaHistorico').val(), page: pagina },
         success: function(response) {
             paginaActual = pagina;
             construirTabla(response);
             // Eliminar la paginación anterior antes de cargar una nueva
             $('#tablaContenedor .pagination').remove();
             manejarPaginacion(response);
         },
         error: function() {
             mostrarAlerta('error', 'Error al obtener los datos.');
         }
     });
 }

 $(document).ready(function() {
     $('#fechaHistorico').on('change', function() {
         cargarPagina(1);
     });
 });