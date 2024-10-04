document.addEventListener('DOMContentLoaded', function () {
    const players = document.querySelectorAll('.soundwave-player');

    players.forEach(player => {
        const canvas = player.querySelector('.soundwave-canvas');
        const context = canvas.getContext('2d');
        const audio = player.querySelector('audio');
        const playButton = player.querySelector('.playPauseBtn');
        const timeDisplay = player.querySelector('.time-display');
        const bars = 50; // Número de barras en la onda

        // Web Audio API
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const analyser = audioContext.createAnalyser();
        const source = audioContext.createMediaElementSource(audio);
        source.connect(analyser);
        analyser.connect(audioContext.destination);

        analyser.fftSize = 256;
        const bufferLength = analyser.frequencyBinCount; // Número de datos de frecuencia
        const dataArray = new Uint8Array(bufferLength); // Array donde se almacenarán los datos

        // Dibujar las ondas de sonido
        function drawWave() {
            analyser.getByteFrequencyData(dataArray); // Obtener los datos de frecuencia

            context.clearRect(0, 0, canvas.width, canvas.height); // Limpiar el canvas
            const width = canvas.width / bars;
            const height = canvas.height;

            // Dibujar las barras en base a los datos de frecuencia
            for (let i = 0; i < bars; i++) {
                const barHeight = (dataArray[i] / 255) * height; // Escalar el valor de frecuencia
                context.fillStyle = '#21d4fd'; // Color de la barra
                context.fillRect(i * width, height - barHeight, width - 2, barHeight); // Dibujar la barra
            }

            if (!audio.paused && !audio.ended) {
                requestAnimationFrame(drawWave);
            }
        }

        // Actualizar el tiempo de la canción y sincronizar la visualización
        audio.addEventListener('play', () => {
            if (audioContext.state === 'suspended') {
                audioContext.resume();
            }
            requestAnimationFrame(drawWave);
        });

        audio.addEventListener('timeupdate', () => {
            const currentTime = audio.currentTime;
            const duration = audio.duration;
            timeDisplay.textContent = formatTime(currentTime) + '/' + formatTime(duration);
        });

        // Formato del tiempo en minutos y segundos
        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return minutes + ':' + (secs < 10 ? '0' : '') + secs;
        }

        // Botón de Play/Pausa
        playButton.addEventListener('click', () => {
            if (audio.paused) {
                audio.play();
                playButton.textContent = '❚❚'; // Cambiar a icono de pausa
            } else {
                audio.pause();
                playButton.textContent = '▶'; // Cambiar a icono de play
            }
        });
    });
});
