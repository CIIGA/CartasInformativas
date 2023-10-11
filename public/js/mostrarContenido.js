// Función que se ejecutará cuando cambie el valor del combo box
function mostrarOcultarContenido() {
    // Obtenemos el valor seleccionado del combo box
    const selectedValue = document.getElementById('combobox').value;

    // Obtenemos el contenedor del contenido que queremos ocultar/mostrar
    const contenido = document.getElementById('content');

    // Verificamos si se ha seleccionado una plaza (valor diferente de vacío)
    if (selectedValue != '') {
        // Verificamos si se ha seleccionado la plaza "Mexicali" (valor "2023")
        // Obtenemos el contenedor del campaña de correos 
        const correos = document.getElementById('correos');
        // if (selectedValue === '2023') {
        //     correos.style.display = 'flex';
        // }
        // else{
        //     correos.style.display = 'none';
        // }

        contenido.style.display = 'flex'; // Mostramos el contenedor con display:flex
    } else {
        contenido.style.display = 'none'; // Ocultamos el contenedor
    }
}

// Agregamos el evento 'change' al combo box para ejecutar la función cuando cambie el valor
document.getElementById('combobox').addEventListener('change', mostrarOcultarContenido);

// Llamamos a la función una vez para que se oculte/muestre el contenido al cargar la página
mostrarOcultarContenido();
