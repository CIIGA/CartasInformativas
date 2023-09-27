function mostrarAlerta(tipo, mensaje) {
    let icono, titulo;

    if (tipo === 'success') {
        icono = 'success';
        titulo = 'Éxito';
    } else if (tipo === 'error') {
        icono = 'error';
        titulo = 'Error';
    } else {
        // Si se pasa un tipo desconocido, asumimos que es un error
        icono = 'error';
        titulo = 'Error';
        mensaje = 'Se ha producido un error inesperado.';
    }

    Swal.fire({
        icon: icono,
        title: titulo,
        text: mensaje,
        showConfirmButton: true,
    });
}