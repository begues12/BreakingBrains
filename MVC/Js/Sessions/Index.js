document.addEventListener('DOMContentLoaded', function () {
    const audioElement = document.getElementById('audio');
    const playPauseBtn = document.getElementById('playPauseBtn');
    const titleElement = document.getElementById('audioTitle');
    const canvas = document.getElementById('audioVisualizer');
    const canvasCtx = canvas.getContext('2d');
    let audioContext, analyzer, dataArray, bufferLength;

    function initAudioVisualizer() {
        audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const source = audioContext.createMediaElementSource(audioElement);
        analyzer = audioContext.createAnalyser();
        source.connect(analyzer);
        analyzer.connect(audioContext.destination);
        analyzer.fftSize = 2048;

        bufferLength = analyzer.frequencyBinCount;
        dataArray = new Uint8Array(bufferLength);

        drawVisualizer();
    }

    function drawVisualizer() {
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

    function playPauseAudio() {
        if (audioElement.paused) {
            audioElement.play();
            playPauseBtn.textContent = 'Pausar';
            if (!audioContext) {
                initAudioVisualizer();
            }
        } else {
            audioElement.pause();
            playPauseBtn.textContent = 'Reproducir';
        }
    }

    // Cambiar la sesión
    window.playSession = function (src, title) {
        audioElement.src = src;
        titleElement.textContent = title;
        playPauseBtn.textContent = 'Pausar';
        if (!audioContext) {
            initAudioVisualizer();
        }
        audioElement.play();
    };

    playPauseBtn.addEventListener('click', playPauseAudio);
});
