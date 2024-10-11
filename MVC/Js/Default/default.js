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
