document.addEventListener("DOMContentLoaded", function () {

    // Cuando el usuario selecciona una opción del combobox
    $("#combobox").change(function () {
        var plazaId = $(this).val();
        $("#plazaId").val(plazaId); // Actualizar el valor del campo oculto
    });

    // Cuando el usuario hace clic en el botón para subir los archivos
    $("#formSubirArchivos").submit(function (e) {
        e.preventDefault(); // Evitar el envío automático del formulario

       
        // Obtener el ID de la plaza seleccionada
        var plazaId = $("#combobox").val();

        // Asignar el valor del ID de la plaza al campo oculto
        $("#plazaId").val(plazaId);

        // Enviar el formulario manualmente
        $.ajax({
            url: "https://gallant-driscoll.198-71-62-113.plesk.page/implementta/modulos/CartasInformativas/public/index.php/guardar_archivos/",
            type: $(this).attr('method'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (response) {
                // Mostrar la alerta de éxito con el mensaje de la respuesta
                mostrarAlerta('success', response.success);
                
            },
            error: function (xhr, status, error) {
                // Mostrar la alerta de error con el mensaje de la respuesta
                mostrarAlerta('error', response.error);
            }
        });
    });
});