let isExpanded = false;
let currentExpandedImage = null;

function toggleExpandImage(imageElement) {
    if (!isExpanded) {
        imageElement.classList.add('expanded');
        currentExpandedImage = imageElement;
        isExpanded = true;
    } else {
        imageElement.classList.remove('expanded');
        currentExpandedImage = null;
        isExpanded = false;
    }
}

document.querySelectorAll('.image-gallery').forEach(function(image) {
    image.addEventListener('click', function() {
        if (currentExpandedImage && currentExpandedImage !== image) {
            toggleExpandImage(currentExpandedImage);
        }
        toggleExpandImage(image);
    });
});

window.onclick = function(event) {
    if (isExpanded && event.target !== currentExpandedImage) {
        toggleExpandImage(currentExpandedImage);
    }
}
