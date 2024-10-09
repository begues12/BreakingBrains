
// Espera a que la página se cargue completamente
document.addEventListener('DOMContentLoaded', function () {
    // Encuentra todos los elementos <code> dentro de <pre>
    var codeBlocks = document.querySelectorAll('pre code');

    // Itera a través de cada bloque de código y aplica el resaltado de sintaxis
    codeBlocks.forEach(function (codeBlock) {
        Prism.highlightElement(codeBlock);
    });
    sendToServer('Contact', 'SendEmail', formData);
});

