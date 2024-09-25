document.addEventListener('DOMContentLoaded', function() {
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
