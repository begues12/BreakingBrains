document.addEventListener('DOMContentLoaded', function () {
    const voteButtons = document.querySelectorAll('.btn-vote');

    voteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const contestantId = this.getAttribute('data-id');
            
            this.disabled = true;
            this.addClass('disabled');

            sendToServer("Halloween", "Vote", {"id": contestantId})
            .then(data => {
                document.body.insertAdjacentHTML('beforeend', data[0]['alert']);
                //reload the page
                setTimeout(function () {
                    location.reload();
                }, 3000);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});

// If exists
if (document.getElementById('upload-container')) {
    document.getElementById('upload-container').addEventListener('click', function() {
        document.getElementById('participant_image').click();
    });
}

// Quitar la cookie de votación y recargar la página


// Si se ha borrado la cookie, recargar la página
if (document.cookie.includes('voted_halloween')){
    document.cookie = "voted_halloween=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    location.reload();
}

function resetVotes()
{
    data = sendToServer("Halloween", "ResetVotes", {})
    .then(data => {
        insertAlert(data[0]['alert']);
        document.cookie = "voted_halloween=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        setTimeout(function () {
            location.reload();
        }, 3000);
    })
    .catch(error => {
        console.error('Error:', error);
    });
    
    return data;
}

function openVotes()
{
    data = sendToServer("Halloween", "OpenVotes", {})
    .then(data => {
        insertAlert(data[0]['alert']);
        setTimeout(function () {
            // location.reload();
        }, 3000);
    })
    .catch(error => {
        console.error('Error:', error);
    });

    return data;
}

function closeVotes()
{
    data = sendToServer("Halloween", "CloseVotes", {})
    .then(data => {
        insertAlert(data[0]['alert']);
        setTimeout(function () {
            location.reload();
        }, 3000);
    })
    .catch(error => {
        console.error('Error:', error);
    });

    return data;
}

function finishVotes()
{
    data = sendToServer("Halloween", "FinishVotes", {})
    .then(data => {
        insertAlert(data[0]['alert']);
        setTimeout(function () {
            location.reload();
        }, 3000);
    })
    .catch(error => {
        console.error('Error:', error);
    });

    return data;
}

function clearParticipants()
{
    data = sendToServer("Halloween", "ClearParticipants", {})
    .then(data => {
        insertAlert(data[0]['alert']);
        setTimeout(function () {
            location.reload();
        }, 3000);
    })
    .catch(error => {
        console.error('Error:', error);
    });

    return data;
}

function sendMail() {
    let form = document.getElementById('halloween-form');
    let formData = new FormData(form);

    $.ajax({
        type: "POST",
        url: "?Ctrl=Halloween&Action=sendEmail",
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
}
