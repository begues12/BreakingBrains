$(document).ready(function () {

    setTimeout(function () {
        $.ajax({
            url: "?Ctrl=FrameworkEditor&Do=Status&Action=getStats",
            type: "GET",
            dataType: "json",
            success: function (data) {
                // Set the status of the environment
                $("#status").html(data.Status);
            }
        });    
    }, 1500);

});