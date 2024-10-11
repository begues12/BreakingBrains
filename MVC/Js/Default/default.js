function sendToServer(controller, action, data) {
    return fetch(`?Ctrl=${controller}&Action=${action}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();  // Aquí asumimos que el servidor devuelve un JSON
    })
    .then(data => {
        // Convierte el JSON a un array si es posible
        return Array.isArray(data) ? data : Object.values(data);
    })
    .catch((error) => {
        console.error('Error:', error);
        return [];  // Devuelve un array vacío en caso de error
    });
}


function closeAlert(target) {
    if (target) {
        setTimeout(function () {
            alertElement.classList.add('fade-out'); // Añade la clase para el fade-out
        }, 3000); // Espera 5 segundos antes de empezar el fade-out

        // Opcional: remover completamente el mensaje del DOM después del fade-out
        setTimeout(function () {
            alertElement.style.display = 'none'; // Ocultar el elemento tras el fade-out
            alertElement.parentNode.removeChild(target);
        }, 4000); // Deja un segundo más para completar la transición antes de ocultarlo
    }
}