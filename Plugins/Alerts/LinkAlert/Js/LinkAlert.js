document.addEventListener('DOMContentLoaded', function() {
    const alertContainer = document.querySelector('.alert-container');
    
    // Mostrar la alerta
    function showAlert() {
        alertContainer.classList.add('visible');
        data = sendToServer('ServerActions', 'index', 'ShowAlert', true);
    }

    function hideAlert() {
        alertContainer.classList.remove('visible');
        alertContainer.style.right = -alertContainer.offsetWidth - 20 + 'px';
    }

    document.querySelector('.close').addEventListener('click', function() {
        hideAlert();
    });

    setTimeout(showAlert, 200); // Aparece después de 100ms
});
