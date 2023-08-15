$(document).ready(function () {
    // Cuando el usuario selecciona una opción del combobox
    $("#combobox").change(function () {
        var plazaId = $(this).val();

        // Actualizar el valor del campo oculto "plaza_id"
        $("#idPlazaC").val(plazaId);
    });

    // Cuando el usuario envía el formulario
    $("form").submit(function (e) {
        e.preventDefault(); // Evitar el envío automático del formulario

        // Obtener el ID de la plaza seleccionada
        var plazaId = $("#combobox").val();

        // Asignar el valor del ID de la plaza al campo oculto
        $("#idPlazaC").val(plazaId);

        // Enviar el formulario manualmente
        this.submit();
    });
});