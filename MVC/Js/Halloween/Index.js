document.addEventListener('DOMContentLoaded', function () {
    const voteButtons = document.querySelectorAll('.btn-vote');

    voteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const contestantId = this.getAttribute('data-id');
            
            // Llamada a sendToServer
            sendToServer("Halloween", "Vote", {"id": contestantId})
            .then(data => {
                document.body.insertAdjacentHTML('beforeend', data[0]['alert']);
                console.log(data[0]['alert']);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});


function resetVotes()
{
    alert("resetVotes");
    data = sendToServer("Halloween", "ResetVotes", {});
    insertAlert(data[0]['alert']);

    return data;
}