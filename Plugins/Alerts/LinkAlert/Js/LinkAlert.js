document.addEventListener('DOMContentLoaded', function() {
    const alertContainer = document.querySelector('.alert-container');
    
    // Mostrar la alerta
    function showAlert() {
        alertContainer.classList.add('visible');
        data = sendToServer('ServerActions', 'index', 'ShowAlert', true);
    }

    // Ocultar la alerta al cerrar
    function hideAlert() {
        alertContainer.classList.remove('visible');
        alertContainer.style.right = '-300px'; // Desliza hacia afuera
    }

    // Botón de cerrar
    document.querySelector('.close').addEventListener('click', function() {
        hideAlert();
    });

    // Simulación de la aparición de la alerta
    setTimeout(showAlert, 100); // Aparece después de 100ms
});
