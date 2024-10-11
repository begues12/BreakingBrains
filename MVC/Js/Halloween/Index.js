document.addEventListener('DOMContentLoaded', function () {
    const voteButtons = document.querySelectorAll('.btn-vote');

    voteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const contestantId = this.getAttribute('data-id');
            
            // Llamada a sendToServer
            sendToServer("Halloween", "Vote", {"id": contestantId})
            .then(data => {
                console.log(data);  // Aquí puedes procesar la respuesta una vez que la promesa se resuelva
                // Add the alert to body viene en data['alert'] como texto
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
    data = sendToServer("Halloween", "ResetVotes", {});
    console.log(data);
    insertAlert(data['alert']);

    return data;
}