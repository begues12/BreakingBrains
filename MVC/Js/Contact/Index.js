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
            document.body.insertAdjacentHTML('beforeend', data[0]['alert']);
        })
        .catch((error) => {
            document.body.insertAdjacentHTML('beforeend', data[0]['alert']);
        });
    });

});