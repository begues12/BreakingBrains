document.addEventListener('DOMContentLoaded', function () {
    const voteButtons = document.querySelectorAll('.btn-vote');

    voteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const contestantId = this.getAttribute('data-id');

            let data = sendToServer("Halloween", "Vote", {'id' : contestantId});
            $("body").append(data['msg']);
        });
    });
});
