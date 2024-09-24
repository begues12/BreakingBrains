document.querySelectorAll('.playPauseBtn').forEach(button => {
    button.addEventListener('click', function() {
        const audioSrc = this.getAttribute('data-audio-src'); // Obtener la URL del audio desde el botón
        const sessionItem = this.parentElement;
        const audio = sessionItem.querySelector('.audio-player');
        const progressBar = sessionItem.querySelector('.audio-progress');
        const timeDisplay = sessionItem.querySelector('.time-display'); // Elemento que muestra el tiempo
        const img = sessionItem.querySelector('img'); // Imagen del vinilo

        // Solo establece el src si no se ha establecido previamente
        if (!audio.src) {
            audio.src = audioSrc; // Asignar la URL del audio al reproductor solo la primera vez
        }

        // Controla el play y pause del audio
        if (audio.paused) {
            audio.play();
            this.innerHTML = '⏸'; // Cambiar icono a pausa
            img.classList.add('playing'); // Añadir clase para rotación
        } else {
            audio.pause();
            this.innerHTML = '▶'; // Cambiar icono a play
            img.classList.remove('playing'); // Detener la rotación
        }

        // Actualizar barra de progreso y el tiempo en cada actualización de tiempo
        audio.addEventListener('timeupdate', () => {
            const value = (audio.currentTime / audio.duration) * 100;
            progressBar.value = value;

            // Actualizar el tiempo transcurrido y total
            const currentTime = formatTime(audio.currentTime);
            const totalTime = formatTime(audio.duration);
            timeDisplay.textContent = `${currentTime}/${totalTime}`;
        });

        // Control de la barra de progreso
        progressBar.addEventListener('input', () => {
            audio.currentTime = (progressBar.value / 100) * audio.duration;
        });

        // Mostrar el tiempo total cuando se carguen los metadatos del audio
        audio.addEventListener('loadedmetadata', () => {
            const totalTime = formatTime(audio.duration);
            timeDisplay.textContent = `00:00/${totalTime}`;
        });
    });
});

// Función para formatear el tiempo en mm:ss
function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60).toString().padStart(2, '0');
    return `${minutes}:${secs}`;
}
