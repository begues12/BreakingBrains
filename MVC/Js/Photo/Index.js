let currentSlideIndex = 0;
const photos = JSON.parse(document.getElementById('photo-data').textContent);

function openModal(index) {
    currentSlideIndex = index;
    showSlide(currentSlideIndex);
    document.getElementById('imageModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('imageModal').style.display = 'none';
}

function changeSlide(step) {
    currentSlideIndex += step;
    if (currentSlideIndex >= photos.length) currentSlideIndex = 0;
    if (currentSlideIndex < 0) currentSlideIndex = photos.length - 1;
    showSlide(currentSlideIndex);
}

function showSlide(index) {
    const carouselSlides = document.getElementById('carouselSlides');
    carouselSlides.innerHTML = `
        <img src="Assets/Images/TeamPhoto/${photos[index]}" class="modal-image" alt="Photo">
    `;
}

window.onclick = function(event) {
    const modal = document.getElementById('imageModal');
    if (event.target == modal) {
        closeModal();
    }
}
