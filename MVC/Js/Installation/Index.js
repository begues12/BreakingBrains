$(document).ready(function () {

    $('#btnSubmit').click(function (e) {
        e.preventDefault();
        showLoading();

        var form = $('#formBd');
        var url = form.attr('action');

        var formData = new FormData(form[0]);

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                var data = JSON.parse(data);                
                $('body').append(data.html);
                hideLoading();
                // Wait 3s to redirect
                setTimeout(function () {
                    window.location.href = "?Ctrl=Installation&Do=Plugins";
                }, 1500);
            },
            error: function  (data) {
                $('body').append(data.html);
                hideLoading();
            }

        });
    });
});
