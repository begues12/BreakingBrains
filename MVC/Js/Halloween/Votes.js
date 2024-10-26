document.querySelectorAll('.vote-button').forEach(button => {
    button.addEventListener('click', function() {
        const contestantId  = this.getAttribute('data-contestant-id');
        // In $_get data are the hash
        const hash          = this.getAttribute('data-contestant-hash');
        fetch('?Ctrl=Halloween&Do=Votes&Action=vote', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ contestant_id: contestantId, hash: hash }),
        })
        .then(response => response.json())
        .then(data => {
            document.body.insertAdjacentHTML('beforeend', data[0]['alert']);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
