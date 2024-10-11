document.addEventListener('DOMContentLoaded', function () {
    const alertElement = document.getElementById('basic-alert');
    
    if (alertElement) {
        setTimeout(function () {
            alertElement.classList.add('fade-out'); // Añade la clase para el fade-out
        }, 3000); // Espera 5 segundos antes de empezar el fade-out

        // Opcional: remover completamente el mensaje del DOM después del fade-out
        setTimeout(function () {
            alertElement.style.display = 'none'; // Ocultar el elemento tras el fade-out
            alertElement.parentNode.removeChild(alertElement);
        }, 4000); // Deja un segundo más para completar la transición antes de ocultarlo
    }
});
