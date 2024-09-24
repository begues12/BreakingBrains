document.addEventListener('DOMContentLoaded', function () {
    console.log("DOM fully loaded and parsed");

    // Seleccionar todos los contenedores de sesiones
    const sessionItems = document.querySelectorAll('.session-item');

    sessionItems.forEach(sessionItem => {
        const audioElement = sessionItem.querySelector('.audio-player');
        const playPauseBtn = sessionItem.querySelector('.playPauseBtn');
        const titleElement = sessionItem.querySelector('.audioTitle');
        const canvas = sessionItem.querySelector('.audioVisualizer');
        const canvasCtx = canvas ? canvas.getContext('2d') : null;
        let audioContext, analyzer, dataArray, bufferLength;

        console.log("Session item initialized", { audioElement, playPauseBtn, titleElement });

        function initAudioVisualizer() {
            console.log("Initializing audio visualizer");
            try {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const source = audioContext.createMediaElementSource(audioElement);
                analyzer = audioContext.createAnalyser();
                source.connect(analyzer);
                analyzer.connect(audioContext.destination);
                analyzer.fftSize = 2048;

                bufferLength = analyzer.frequencyBinCount;
                dataArray = new Uint8Array(bufferLength);

                drawVisualizer();
            } catch (error) {
                console.error("Error initializing audio visualizer:", error);
            }
        }

        function drawVisualizer() {
            if (!canvasCtx) return;
            console.log("Drawing visualizer");

            requestAnimationFrame(drawVisualizer);

            analyzer.getByteTimeDomainData(dataArray);

            canvasCtx.fillStyle = '#222';
            canvasCtx.fillRect(0, 0, canvas.width, canvas.height);

            canvasCtx.lineWidth = 2;
            canvasCtx.strokeStyle = '#00d9ff';

            canvasCtx.beginPath();
            const sliceWidth = canvas.width * 1.0 / bufferLength;
            let x = 0;

            for (let i = 0; i < bufferLength; i++) {
                const v = dataArray[i] / 128.0;
                const y = v * canvas.height / 2;

                if (i === 0) {
                    canvasCtx.moveTo(x, y);
                } else {
                    canvasCtx.lineTo(x, y);
                }

                x += sliceWidth;
            }

            canvasCtx.lineTo(canvas.width, canvas.height / 2);
            canvasCtx.stroke();
        }

        async function playPauseAudio() {
            console.log("Play/Pause button clicked", audioElement.paused ? "Playing" : "Pausing");

            if (audioElement.paused) {
                try {
                    await audioElement.play();
                    console.log("Audio is playing");
                    playPauseBtn.textContent = 'Pausar';
                    if (!audioContext) {
                        console.log("Initializing visualizer since audioContext is null");
                        initAudioVisualizer();
                    }
                } catch (error) {
                    console.error("Error al reproducir el audio:", error);
                }
            } else {
                console.log("Pausing audio");
                audioElement.pause();
                playPauseBtn.textContent = 'Reproducir';
            }
        }
        
        // Cambiar la sesión (cada sesión tiene su propio audio y título)
        window.playSession = function (src, title) {
            console.log("Changing session to", { src, title });
            audioElement.src = src;
            if (titleElement) titleElement.textContent = title;
            playPauseBtn.textContent = 'Pausar';
            if (!audioContext) {
                console.log("Initializing visualizer on session change");
                initAudioVisualizer();
            }
            audioElement.play().then(() => {
                console.log("Session audio playing");
            }).catch(error => {
                console.error("Error al cambiar la sesión y reproducir:", error);
            });
        };

        // Agregar event listener para play/pause a cada botón
        playPauseBtn.addEventListener('click', function() {
            playPauseAudio();
        });

        console.log("Event listeners added for play/pause button");
    });
});
