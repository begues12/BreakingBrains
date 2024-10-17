document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.dj-menu li').forEach(function(menuItem) {
        menuItem.addEventListener('click', function() {
            var selectedDJ = this.getAttribute('data-dj');
            
            // Cambiar la clase activa en el menú
            document.querySelectorAll('.dj-menu li').forEach(function(item) {
                item.classList.remove('active');
            });
            this.classList.add('active');

            // Hacer fade out de la imagen activa
            var activeTile = document.querySelector('.dj-tile.active');
            if (activeTile) {
                fadeOut(activeTile, function() {
                    // Una vez que se complete el fade out, hacer fade in en la imagen seleccionada
                    activeTile.classList.remove('active');
                    var selectedTile = document.getElementById(selectedDJ);
                    fadeIn(selectedTile);
                    selectedTile.classList.add('active');
                });
            }
        });
    });
});

// Función para hacer fade out
function fadeOut(element, callback) {
    element.style.opacity = 1;

    (function fade() {
        if ((element.style.opacity -= 0.1) < 0) {
            element.style.display = "none";
            if (callback) callback();
        } else {
            requestAnimationFrame(fade);
        }
    })();
}

// Función para hacer fade in
function fadeIn(element) {
    element.style.display = "block";
    element.style.opacity = 0;

    (function fade() {
        var val = parseFloat(element.style.opacity);
        if (!((val += 0.1) > 1)) {
            element.style.opacity = val;
            requestAnimationFrame(fade);
        }
    })();
}
