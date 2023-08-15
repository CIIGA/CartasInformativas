$(document).ready(function () {
    // Cuando el usuario selecciona una opción del combobox
    $("#combobox").change(function () {
        var plazaId = $(this).val();
        // Realizar la petición AJAX para obtener la lista de archivos de la plaza
        $.ajax({
            url: "/plazas/" + plazaId + "/imagen", // Ruta de la función obtenerImagenPlaza del controlador
            type: "GET",
            xhrFields: {
                responseType: 'blob' // Indicar que esperamos una respuesta en formato binario (imagen)
            },
            success: function (data) {
                // Crear una URL para mostrar la imagen en la tarjeta de Bootstrap
                var urlImagen = URL.createObjectURL(data);
                
                // Actualizar la tarjeta con la imagen y la información de la plaza
                $("#imagenPlaza").attr("src", urlImagen); // Establecer la imagen 
            },
            error: function (xhr, status, error) {
                mostrarAlerta('error', 'No se encontro la imagen');
            }
        });
    });
});