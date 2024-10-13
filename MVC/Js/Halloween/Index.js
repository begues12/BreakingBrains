document.addEventListener('DOMContentLoaded', function () {
    const voteButtons = document.querySelectorAll('.btn-vote');

    voteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const contestantId = this.getAttribute('data-id');
            
            // Llamada a sendToServer
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