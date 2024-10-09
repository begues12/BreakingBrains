/*document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(form);
        fetch('?Ctrl=Contact&Action=SendEmail', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log('Success:', data);
            alert('Mensaje enviado correctamente!');
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Error al enviar el mensaje.');
        });
    });
});
Estp es ima funcion para enviar info al servidor creame una funcion que pueda ser reutilizada en cualquier parte del codigo
*/
// Do is 
function sendToServer(controller, action, data)
{

    fetch(`?Ctrl=${controller}&Action=${action}`, {
        method: 'POST',
        body: data
    })
    .then(response => response.text())
    .then(data => {
        return data;
    })
    .catch((error) => {
        return error;
    });
}