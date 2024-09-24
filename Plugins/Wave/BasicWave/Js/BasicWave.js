document.addEventListener('DOMContentLoaded', function () {
    const bars = document.querySelectorAll('.bar');

    function randomizeBars() {
        bars.forEach(bar => {
            const randomHeight = Math.floor(Math.random() * 100) + 10; // Genera una altura aleatoria entre 10 y 100px
            bar.style.height = randomHeight + 'px';
        });
    }

    // Cambia la altura de las barras cada 300ms
    setInterval(randomizeBars, 100);
});
