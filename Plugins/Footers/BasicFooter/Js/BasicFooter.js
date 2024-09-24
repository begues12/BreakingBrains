function moveFooterToBottom() {
    const footer = document.getElementById('basic-footer')
    const content = document.getElementById("main-content");

    const contentHeight = content.offsetHeight;
    const windowHeight = window.innerHeight;
    const footerHeight = footer.offsetHeight;
    //Get margins of footer and content
    const footerMarginTop = parseInt(window.getComputedStyle(footer).getPropertyValue("margin-top"));
    const footerMarginBottom = parseInt(window.getComputedStyle(footer).getPropertyValue("margin-bottom"));

    if (contentHeight < windowHeight) {
        const offset = (windowHeight - footerHeight) - (footerMarginTop + footerMarginBottom);
        footer.style.position = "absolute";
        footer.style.top = offset + "px";
    } else {
        footer.style.transform = "none";
    }
}

window.addEventListener("DOMContentLoaded", moveFooterToBottom);
window.addEventListener("resize", moveFooterToBottom);
