
$(document).ready(function () {
    $(".img-thumbnail").click(function () {
        if ($(this).hasClass("img-thumbnail")) {
            $(this).removeClass("img-thumbnail");
            $(this).addClass("img-fluid");
        } else {
            $(this).removeClass("img-fluid");
            $(this).addClass("img-thumbnail");
        }
    });
});