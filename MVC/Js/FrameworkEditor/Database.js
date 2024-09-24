$(document).ready(function () {
    getDatabases();
});

function getDatabases()
{
    showLoading();

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip('hide');
    });

    $.ajax({
        type: "POST",
        url: "?Ctrl=FrameworkEditor&Do=Database&Action=GetDatabases",
        success: function (data) {
            if (data.length != 0){
                $('#divContainerBd').html(data);
            }
            hideLoading();
        },
        error: function  (data) {
            hideLoading();
        }
    });
}

function showTable(element)
{
    showLoading();

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip('hide');
    });

    var url = $(element).attr('href');
    $.ajax({
        type: "POST",
        url: url,
        success: function (data) {
            // If data is empty, it means that the table is empty
            if (data.length != 0){
                $('#divContainerBd').html(data);
            }
            hideLoading();
        },
        error: function  (data) {
            hideLoading();
        }
    });
}


function showDataTable(element)
{

    showLoading();

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip('hide');
    });

    var url = $(element).attr('href');

    var database = $(element).data('database');
    var table = $(element).data('table');
    
    $.ajax({
        type: "POST",
        url: url,
        data: {'data-database': database, 'data-table': table}, // serializes the form's elements.
        success: function (data) {
            // If data is empty, it means that the table is empty
            if (data.length != 0){
                $('#divContainerBd').html(data);
            }
            hideLoading();
        },
        error: function  (data) {
            hideLoading();
        }
    });
}