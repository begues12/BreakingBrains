$(document).ready(function () {
    $('#myModal').on('show.bs.modal', function () {
        $(this).find('.modal-dialog').setClass('modal-dialog-slide');
    });

    // Cierra el modal y el fondo negro al hacer clic en el icono "cross"
    $('#modalCloseIcon').on('click', function () {
        $('#myModal').modal('hide');
    });
});
