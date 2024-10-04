document.addEventListener('DOMContentLoaded', function () {
    const players = document.querySelectorAll('.soundwave-player');

    players.forEach(player => {
        const canvas = player.querySelector('.soundwave-canvas');
        const context = canvas ? canvas.getContext('2d') : null;
        const audio = player.querySelector('.audio-player');
        const playButton = player.querySelector('.playPauseBtn');
        const timeDisplay = player.querySelector('.time-display');

        if (!canvas || !context || !audio || !playButton || !timeDisplay) {
            console.error("No se encontraron todos los elementos necesarios.");
            return;
        }

        let barWidth = 2; // Ancho de cada barra
        let barSpacing = 5; // Espacio entre barras
        let bars; // Número de barras en el canvas
        let barProgress = 0;
        let isSeeking = false;

        const minBarHeight = 5; // Altura mínima para cada barra

        // Aumentar la resolución del canvas para evitar pixelación
        function resizeCanvas() {
            const devicePixelRatio = window.devicePixelRatio || 1;
            canvas.width = canvas.clientWidth * devicePixelRatio;
            canvas.height = canvas.clientHeight * devicePixelRatio;
            context.scale(devicePixelRatio, devicePixelRatio);
            bars = Math.floor(canvas.width / (barWidth + barSpacing) / devicePixelRatio);
        }

        // Inicializar el tamaño del canvas
        resizeCanvas();

        // Redimensionar el canvas y recalcular las barras en caso de que cambie el tamaño de la ventana
        window.addEventListener('resize', function () {
            resizeCanvas();
            drawWave(); // Redibujar la onda cuando cambie el tamaño
        });

        // Inicializar la API de Web Audio
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const analyser = audioContext.createAnalyser();
        const source = audioContext.createMediaElementSource(audio);
        source.connect(analyser);
        analyser.connect(audioContext.destination);

        analyser.fftSize = 256;
        const bufferLength = analyser.frequencyBinCount;
        const dataArray = new Uint8Array(bufferLength);

        // Dibujar la onda de sonido
        function drawWave() {
            analyser.getByteFrequencyData(dataArray);

            // Limpiar el canvas antes de redibujar
            context.clearRect(0, 0, canvas.clientWidth, canvas.clientHeight);
            const height = canvas.clientHeight;

            for (let i = 0; i < bars; i++) {
                const x = i * (barWidth + barSpacing);
                // Altura de la barra, asegurando que no sea menor que la altura mínima
                let barHeight = (dataArray[i] / 255) * height / 2;
                barHeight = Math.max(barHeight, minBarHeight);

                // Decidir el color de la barra según el progreso
                if (i < barProgress) {
                    context.fillStyle = '#21d4fd'; // Barras ya reproducidas en color azul
                } else {
                    context.fillStyle = '#ccc'; // Barras no reproducidas en gris
                }

                // Dibujar la barra con puntas redondeadas
                context.beginPath();
                context.moveTo(x, (height / 2) - barHeight);
                context.lineTo(x + barWidth, (height / 2) - barHeight);
                context.quadraticCurveTo(x + barWidth + 1, height / 2, x + barWidth, (height / 2) + barHeight);
                context.lineTo(x, (height / 2) + barHeight);
                context.quadraticCurveTo(x - 1, height / 2, x, (height / 2) - barHeight);
                context.fill();
            }

            requestAnimationFrame(drawWave);
        }

        // Mostrar el tiempo total de la canción cuando los metadatos están cargados
        audio.addEventListener('loadedmetadata', () => {
            const duration = audio.duration;
            timeDisplay.textContent = '00:00/' + formatTime(duration);
        });

        // Actualizar el progreso de la onda a medida que el audio avanza
        audio.addEventListener('timeupdate', () => {
            if (!isSeeking) {
                const currentTime = audio.currentTime;
                const duration = audio.duration;

                barProgress = Math.floor((currentTime / duration) * bars) || 0;

                timeDisplay.textContent = formatTime(currentTime) + '/' + formatTime(duration);
            }
        });

        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return minutes + ':' + (secs < 10 ? '0' : '') + secs;
        }

        // Control de Play/Pausa
        playButton.addEventListener('click', () => {
            if (audio.paused) {
                audioContext.resume();
                audio.play();
                playButton.textContent = '❚❚';
            } else {
                audio.pause();
                playButton.textContent = '▶';
            }
        });

        // Hacer clic en el canvas para buscar en la canción (escritorio)
        canvas.addEventListener('click', function (e) {
            const rect = canvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const seekTime = (x / canvas.clientWidth) * audio.duration;
            audio.currentTime = seekTime;
        });

        // Modo de arrastre para buscar en la canción (escritorio)
        canvas.addEventListener('mousedown', function () {
            isSeeking = true;
            canvas.addEventListener('mousemove', seekAudio);
        });

        canvas.addEventListener('mouseup', function () {
            isSeeking = false;
            canvas.removeEventListener('mousemove', seekAudio);
        });

        // Hacer clic en el canvas para buscar en la canción (móvil)
        canvas.addEventListener('touchstart', function (e) {
            isSeeking = true;
            const touch = e.touches[0];
            const rect = canvas.getBoundingClientRect();
            const x = touch.clientX - rect.left;
            const seekTime = (x / canvas.clientWidth) * audio.duration;
            audio.currentTime = seekTime;
        });

        // Modo de arrastre para buscar en la canción (móvil)
        canvas.addEventListener('touchmove', function (e) {
            if (isSeeking) {
                const touch = e.touches[0];
                const rect = canvas.getBoundingClientRect();
                const x = touch.clientX - rect.left;
                const seekTime = (x / canvas.clientWidth) * audio.duration;
                audio.currentTime = seekTime;
            }
        });

        canvas.addEventListener('touchend', function () {
            isSeeking = false;
        });

        function seekAudio(e) {
            const rect = canvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const seekTime = (x / canvas.clientWidth) * audio.duration;
            audio.currentTime = seekTime;
        }

        // Iniciar el dibujo de la onda al cargar la página
        requestAnimationFrame(drawWave);
    });
});
