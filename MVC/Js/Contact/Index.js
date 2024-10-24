document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(form);
        $.ajax({
            type: "POST",
            url: "?Ctrl=Contact&Action=sendEmail",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(data) {
                if (data.alert) {
                    document.body.insertAdjacentHTML('beforeend', data.alert);
                } else if (data['0'] && data['0'].alert) {
                    document.body.insertAdjacentHTML('beforeend', data['0'].alert);
                } else {
                    console.error("No se encontró la alerta en la respuesta.");
                }
                setTimeout(function () {
                    location.reload();
                }, 3000);
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.alert) {
                    document.body.insertAdjacentHTML('beforeend', xhr.responseJSON.alert);
                } else if (xhr.responseJSON && xhr.responseJSON['0'] && xhr.responseJSON['0'].alert) {
                    document.body.insertAdjacentHTML('beforeend', xhr.responseJSON['0'].alert);
                } else {
                    document.body.insertAdjacentHTML('beforeend', "<div class='alert alert-danger'>Error al enviar el correo</div>");
                }
                setTimeout(function () {
                    location.reload();
                }, 3000);
            }
        });
    });

});
