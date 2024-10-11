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
        setTimeout(function () {
            location.reload();
        }, 3000);
    })
    .catch(error => {
        console.error('Error:', error);
    });

    

    return data;
}