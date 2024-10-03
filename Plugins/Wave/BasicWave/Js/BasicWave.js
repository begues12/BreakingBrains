document.addEventListener('DOMContentLoaded', function () {
    const bars = document.querySelectorAll('.bar');
    
    // if bars's width are so big create news bars to fit the screen
    if (bars.length > 0) {

        setInterval(comproveBars, 5000);
    }

    function randomizeBars() {
        bars.forEach(bar => {
            const scaleFactor           = Math.random() * 2 + 1; // Genera un factor de escala aleatorio entre 0.5 y 2.5
            bar.style.transformOrigin   = 'center'; // Establece el origen en el centro
            bar.style.transform         = `scaleY(${scaleFactor})`; // Aplica el escalado en Y de forma simétrica
        });
    }

    function comproveBars()
    {
        print("comproveBars");
        bars.forEach(bar => {
            const barWidth          = bar.offsetWidth;
            const windowWidth       = window.innerWidth;
            const barMarginLeft     = parseInt(window.getComputedStyle(bar).getPropertyValue('margin-left'));
            const barMarginRight    = parseInt(window.getComputedStyle(bar).getPropertyValue('margin-right'));
            const barTotalWidth     = barWidth + barMarginLeft + barMarginRight;

            if (barTotalWidth > windowWidth) {
                const newBars = Math.ceil(barTotalWidth / windowWidth);
                for (let i = 0; i < newBars; i++) {
                    const newBar = bar.cloneNode(true);
                    bar.parentNode.appendChild(newBar);
                }
            }
        });
    }

    // Cambia el tamaño de las barras cada 100ms
    setInterval(randomizeBars, 100);
});
