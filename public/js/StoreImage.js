document.addEventListener("DOMContentLoaded", function () {
    // Cuando el usuario selecciona una opción del combobox
    $("#combobox").change(function () {
        var plazaId = $(this).val();
        $("#plazaId").val(plazaId); // Actualizar el valor del campo oculto
    });

    // Cuando el usuario hace clic en el botón para subir los archivos
    $("#btnSubirArchivos").on("click", function () {
        var formData = new FormData($("#formSubirArchivos")[0]);
        const archivoInput = document.getElementById("archivo");

        if (archivoInput.files.length === 0) {
            Swal.fire({
                icon: "error",
                title: "Input vacio",
                text: "Selecciona una imagen .jpg",
                showConfirmButton: true,
            });
            return;
        }
        const nombreArchivo = archivoInput.files[0].name;

        // Verificar si la extensión es .jpg
        if (nombreArchivo.endsWith(".jpg")) {
        } else {
            Swal.fire({
                icon: "error",
                title: "Extension erronea",
                text: "Selecciona una imagen con extension .jpg",
                showConfirmButton: true,
            });
            return;
        }

        // Obtener el ID de la plaza seleccionada
        var plazaId = $("#combobox").val();

        // Asignar el valor del ID de la plaza al campo oculto
        $("#plazaId").val(plazaId);

        // Enviar el formulario manualmente
        $.ajax({
            url: "/guardar_archivos",
            // url: "https://gallant-driscoll.198-71-62-113.plesk.page/implementta/modulos/CartasInformativas/public/index.php/guardar_archivos/",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Cierra el modal con el id "exampleModal"
                $("#exampleModal").modal("hide");
                // Obtenemos el contenedor del contenido que queremos ocultar/mostrar
                const contenido = document.getElementById("content");
                contenido.style.display = "none"; // Ocultamos el contenedor

                // Obtén una referencia al elemento select
                var select = document.getElementById("combobox");

                // Establece selectedIndex para seleccionar la opción deseada
                select.selectedIndex = 0; // 1 corresponde a la segunda opción (Opción 2)

                // Mostrar la alerta de éxito con el mensaje de la respuesta
                mostrarAlerta("success", response.success);
            },
            error: function (xhr, status, error) {
                // Mostrar la alerta de error con el mensaje de la respuesta
                mostrarAlerta("error", response.error);
            },
        });
    });
});
