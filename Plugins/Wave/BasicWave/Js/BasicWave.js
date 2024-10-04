document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('barCanvas');
    const ctx = canvas.getContext('2d');
    const logo = document.getElementById('logo-image'); // Obtener el elemento con el ID 'logo-image'
    let barHeights = []; // Almacena las alturas actuales de las barras
    let barTargetHeights = []; // Almacena las alturas objetivo de las barras
    let speedFactors = []; // Almacena las velocidades de cambio de cada barra
    let selectedPoints = []; // Almacena los puntos seleccionados aleatoriamente
    let affectedRanges = []; // Almacena el número de barras afectadas por cada punto

    function getLogoBorderColor() {
        // Verifica que el elemento 'logo' exista antes de intentar obtener su estilo
        if (!logo) {
            console.error("No se encontró el elemento con ID 'logo-image'.");
            return '#00A'; // Color por defecto si no se encuentra el elemento
        }
        
        const style = window.getComputedStyle(logo);
        return style.borderColor || '#00A'; // Color predeterminado si no se encuentra el borde
    }

    function resizeCanvas() {
        canvas.width = canvas.parentElement.offsetWidth;
        canvas.height = canvas.parentElement.offsetHeight;
    }

    // Función para aplicar la curva gaussiana sobre la altura de las barras
    function gaussian(x, mean, variance) {
        const exponent = -Math.pow(x - mean, 2) / (2 * variance);
        return Math.exp(exponent); // Resultado de la función gaussiana
    }

    // Seleccionar varios puntos aleatorios y calcular cuántas barras afecta cada uno
    function selectRandomPoints(numberOfBars) {
        const numberOfPoints = Math.floor(Math.random() * 3) + 2; // Selecciona entre 2 y 5 puntos aleatorios
        selectedPoints = [];
        affectedRanges = [];
        
        for (let i = 0; i < numberOfPoints; i++) {
            const randomPoint = Math.floor(Math.random() * numberOfBars); // Selecciona un punto aleatorio
            const randomRange = Math.floor(Math.random() * (numberOfBars / 5)) + 3; // Afecta entre 3 y numberOfBars/5 barras cercanas
            selectedPoints.push(randomPoint);
            affectedRanges.push(randomRange);
        }
    }

    // Función para generar alturas objetivo aplicando varias curvas gaussianas
    function randomizeTargetHeights(numberOfBars) {
        // Inicializar todas las alturas con un valor aleatorio básico
        for (let i = 0; i < numberOfBars; i++) {
            const scaleFactor = (Math.random() * 1.5 + 0.5) * (Math.random() < 0.5 ? 1 : -1); // Ahora puede ser positivo o negativo
            barTargetHeights[i] = scaleFactor * canvas.height / 2; // Permitir que baje también
            speedFactors[i] = 0.06; // Velocidad de cambio de altura de cada barra
        }
    
        // Aplicar la curva gaussiana en los puntos seleccionados y afectar las barras cercanas
        for (let p = 0; p < selectedPoints.length; p++) {
            const point = selectedPoints[p];
            const range = affectedRanges[p];
            const variance = Math.pow(range / 3, 2); // Variancia que controla cuántas barras son afectadas
            
            // Afectar las barras cercanas al punto seleccionado
            for (let i = Math.max(0, point - range); i < Math.min(numberOfBars, point + range); i++) {
                const distance = Math.abs(i - point);
                const gaussianFactor = gaussian(distance, 0, variance); // Aplicar la curva gaussiana
                const scaleFactor = (Math.random() * 1.5 + 0.5) * (Math.random() < 0.5 ? 1 : -1); // Factor de escala positivo o negativo
                barTargetHeights[i] += gaussianFactor * scaleFactor * canvas.height / 2; // Permitir que las barras bajen
            }
        }
    }
    

    function updateBars() {
        const barWidth = 2; // Ancho fijo de las barras
        const barSpacing = 5; // Separación de 5 píxeles entre cada barra
        const totalBarWidth = barWidth + barSpacing; // El espacio total ocupado por cada barra incluyendo la separación
        const numberOfBars = Math.floor(canvas.width / totalBarWidth); // Ajustar el número de barras para el ancho del canvas
        const borderColor = getLogoBorderColor(); // Obtener el color actual del borde (sincronizado con la animación)

        // Calcular el espacio sobrante para centrar las barras
        const totalBarsWidth = numberOfBars * totalBarWidth; // Ancho total ocupado por todas las barras
        const startX = (canvas.width - totalBarsWidth) / 2; // Calcular el desplazamiento para centrar las barras

        // Si no hay alturas inicializadas, inicializa los arrays con 0
        if (barHeights.length !== numberOfBars) {
            barHeights = new Array(numberOfBars).fill(0);
            barTargetHeights = new Array(numberOfBars).fill(0);
            speedFactors = new Array(numberOfBars).fill(0);
            selectRandomPoints(numberOfBars); // Selecciona puntos aleatorios
            randomizeTargetHeights(numberOfBars); // Inicializa las alturas objetivo aplicando gaussianas
        }

        // Limpiar el canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Dibujar las barras con interpolación de altura
        for (let i = 0; i < numberOfBars; i++) {
            const x = startX + i * totalBarWidth; // Añadir la separación al cálculo de la posición X de cada barra
            
            // Progresivamente acercarse a la altura objetivo de manera aleatoria
            const currentHeight = barHeights[i];
            const targetHeight = barTargetHeights[i];
            const step = (targetHeight - currentHeight) * speedFactors[i]; // Paso de interpolación aleatorio para cada barra
            barHeights[i] += step; // Actualizar altura con suavidad

            // Si la barra ha alcanzado o superado su altura objetivo, asignar un nuevo objetivo
            if (Math.abs(barHeights[i] - barTargetHeights[i]) < 1) {
                selectRandomPoints(numberOfBars); // Elegir nuevos puntos aleatorios
                randomizeTargetHeights(numberOfBars); // Aplicar gaussianas a las barras cercanas
            }

            const y = (canvas.height - barHeights[i]) / 2; // Centrarlas verticalmente

            // Baja el dibujo de las barras para que no se superpongan con el logo

            // Dibujar barra con color y bordes redondeados
            ctx.fillStyle = borderColor; // Usar el color basado en el borde animado de #logo-image
            ctx.beginPath();
            ctx.moveTo(x + 2, y); // Esquina superior izquierda redondeada
            ctx.arcTo(x + barWidth, y, x + barWidth, y + barHeights[i], 2); // Esquina superior derecha redondeada
            ctx.arcTo(x + barWidth, y + barHeights[i], x, y + barHeights[i], 2); // Esquina inferior derecha redondeada
            ctx.arcTo(x, y + barHeights[i], x, y, 2); // Esquina inferior izquierda redondeada
            ctx.arcTo(x, y, x + barWidth, y, 2); // Esquina superior izquierda redondeada
            ctx.fill();
        }
    }

    function animateBars() {
        updateBars(); // Actualiza las barras con suavidad
        requestAnimationFrame(animateBars); // Continuar la animación en cada cuadro
    }

    // Redimensiona el canvas al cargar la página y cuando se cambie el tamaño de la ventana
    window.addEventListener('resize', function() {
        resizeCanvas();
        const numberOfBars = Math.floor(canvas.width / (6 + 5)); // Recalcular el número de barras
        selectRandomPoints(numberOfBars); // Seleccionar nuevos puntos aleatorios cuando cambie el tamaño
        randomizeTargetHeights(numberOfBars); // Cambiar las alturas objetivo aplicando gaussianas
    });

    // Inicializar
    resizeCanvas();
    animateBars(); // Inicia la animación progresiva de las barras
});
