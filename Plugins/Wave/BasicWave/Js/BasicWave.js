document.addEventListener('DOMContentLoaded', function () {
    const bars = document.querySelectorAll('.bar');
    

    function randomizeBars() {
        bars.forEach(bar => {
            const scaleFactor           = Math.random() * 2 + 1; // Genera un factor de escala aleatorio entre 0.5 y 2.5
            bar.style.transformOrigin   = 'center'; // Establece el origen en el centro
            bar.style.transform         = `scaleY(${scaleFactor})`; // Aplica el escalado en Y de forma simétrica
        });
    }

    // Cambia el tamaño de las barras cada 100ms
    setInterval(randomizeBars, 100);
    // setInterval(comproveBars, 5000);

});

// Al cambiar el tamaño de la pantalla mira si las barras ocupan toda la pantalla y si no añade más barras

function comproveBars() {
    const bars = document.querySelectorAll('.bar');
    const content = document.getElementById("main-content");
    const contentHeight = content.offsetHeight;
    const windowHeight = window.innerHeight;
    const barsHeight = bars[0].offsetHeight;
    const barsMarginTop = parseInt(window.getComputedStyle(bars[0]).getPropertyValue("margin-top"));
    const barsMarginBottom = parseInt(window.getComputedStyle(bars[0]).getPropertyValue("margin-bottom"));
    const barsTotalHeight = barsHeight + barsMarginTop + barsMarginBottom;
    const barsNumber = bars.length;
    const barsTotalHeightAll = barsTotalHeight * barsNumber;

    if (contentHeight < windowHeight) {
        if (barsTotalHeightAll < windowHeight) {
            const newBar = document.createElement("div");
            newBar.classList.add("bar");
            content.appendChild(newBar);
        }
    }
}
