// Capturar el evento de envío del formulario
document.getElementById('formSubirDatos').addEventListener('submit', function (event) {
    // Prevenir el envío del formulario para mostrar la alerta primero
    event.preventDefault();

    Swal.fire({
      title: 'Obteniendo Datos',
      html: 'Espere un momento por favor...',
      timer: 0,
      timerProgressBar: true,
      allowEscapeKey: false,
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
      willClose: () => {
        return false;
      }
    });
});