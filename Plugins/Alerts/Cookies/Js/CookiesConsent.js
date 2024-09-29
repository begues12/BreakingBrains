document.addEventListener("DOMContentLoaded", function() {
    // Verifica si ya se aceptaron o rechazaron las cookies
    if (!localStorage.getItem("cookiesAccepted")) {
        // Mostrar el popup de cookies si no hay una decisión previa
        document.getElementById("cookies-consent-container").style.display = "block";
    }
});

// Función para aceptar cookies
function acceptCookies() {
    // Guardar en el almacenamiento local que el usuario aceptó las cookies
    localStorage.setItem("cookiesAccepted", "true");
    
    // Ocultar el popup de cookies
    document.getElementById("cookies-consent-container").style.display = "none";

    // Aquí puedes agregar la lógica para habilitar las cookies si es necesario
    enableCookies(); 
}

// Función para rechazar cookies
function declineCookies() {
    // Guardar en el almacenamiento local que el usuario rechazó las cookies
    localStorage.setItem("cookiesAccepted", "false");
    
    // Ocultar el popup de cookies
    document.getElementById("cookies-consent-container").style.display = "none";

    // Aquí puedes agregar la lógica para deshabilitar las cookies si es necesario
    disableCookies();
}

// Ejemplo de función para habilitar cookies (personalízala según tu necesidad)
function enableCookies() {
    console.log("Cookies habilitadas.");
    // Aquí puedes agregar lógica para habilitar cookies o activar scripts de rastreo
}

// Ejemplo de función para deshabilitar cookies (personalízala según tu necesidad)
function disableCookies() {
    console.log("Cookies deshabilitadas.");
    // Aquí puedes agregar lógica para desactivar cookies o scripts de rastreo
}
