$(document).ready(function () {
    // Cuando el usuario selecciona una opción del combobox
    $("#combobox").change(function () {
        var plazaId = $(this).val();
        if (plazaId === '') {
            return;
        }
        // Realizar la petición AJAX para obtener la lista de archivos de la plaza
        $.ajax({
            // url: "/fechasCorreos/" + plazaId,
            url: "https://gallant-driscoll.198-71-62-113.plesk.page/implementta/modulos/CartasInformativas/public/index.php/fechasCorreos/" + plazaId, // Ruta de la función obtenerImagenPlaza del controlador con ajax
            type: "GET",

            success: function (response) {
                var content = $("#correos-content"); //mostramos la tabla reporte con el registro ya eliminado
                content.html(response.contenido);
            },
            error: function (xhr, status, error) {
                // console.log(error);
                Swal.fire({
                    title: "Error",
                    text: "Error de comunicacion comuniquese con soporte",
                    icon: "error",
                    showConfirmButton: true,
                });
            },
        });
    });
});
