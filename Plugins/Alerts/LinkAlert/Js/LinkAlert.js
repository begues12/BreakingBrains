$(document).ready(function () {
    $(".basic-alert").animate({left: '150%'}, "slow");
    // A los 5 segundos de haber cargado la página, cierra la alerta de éxito
    setTimeout(function () {
        // FadeOut to basic alert class
        $('.basic-alert').each(function () {
            $(this).fadeOut(1000);
        });
    }, 2000);
});
