document.querySelectorAll('.playPauseBtn').forEach(button => {
    button.addEventListener('click', function() {
        const audioSrc = this.getAttribute('data-audio-src'); // Obtener la URL del audio desde el botón
        const sessionItem = this.parentElement;
        const audio = sessionItem.querySelector('.audio-player');
        const progressBar = sessionItem.querySelector('.audio-progress');
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

        // Actualizar barra de progreso en cada actualización de tiempo
        audio.addEventListener('timeupdate', () => {
            const value = (audio.currentTime / audio.duration) * 100;
            progressBar.value = value;
        });

        // Control de la barra de progreso
        progressBar.addEventListener('input', () => {
            audio.currentTime = (progressBar.value / 100) * audio.duration;
        });
    });
});
