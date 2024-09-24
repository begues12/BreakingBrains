document.addEventListener('DOMContentLoaded', function () {
    const bars = document.querySelectorAll('.bar');

    function randomizeBars() {
        bars.forEach(bar => {
            const scaleFactor = Math.random() * 2 + 1; // Genera un factor de escala aleatorio entre 0.5 y 2.5
            bar.style.transformOrigin = 'center'; // Establece el origen en el centro
            bar.style.transform = `scaleY(${scaleFactor})`; // Aplica el escalado en Y de forma simétrica
        });
    }

    // Cambia el tamaño de las barras cada 100ms
    setInterval(randomizeBars, 100);
});
