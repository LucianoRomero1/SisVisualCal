$("#filtrar").click(function (e) {

    var isValid = $("#formFiltro").valid();
    if(!isValid) {
      e.preventDefault(); //prevent the default action
      return;
    }

    //Evita el error en Firebox
    e.preventDefault();
    //
    $('#filtrar').attr("disabled",true);
    getRegistros();

});

$(document).on({
    ajaxStart: function () {
        $("#loading").css("display", "block");
    },
    ajaxStop: function () {
        $("#loading").css("display", "none");
    }
});

var requestSent = false;

function getRegistros()
{        
    if (!requestSent) {
        requestSent = true;
        $.ajax({
            type: $('#formFiltro').attr('method'),
            url: $('#formFiltro').attr('action') ,
            data: $('#formFiltro').serialize(),
        })
        .done(function (data) {
            //if (typeof data.message !== 'undefined') {
            //    alert(data.message);
            //}
            $('#resultado').html(data.form);
            $('#filtrar').attr("disabled",false);
            
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 0) {

                alert('Not connect: Verify Network.');
            
              } else if (jqXHR.status == 404) {
            
                alert('Requested page not found [404]');
            
              } else if (jqXHR.status == 500) {
            
                alert('Internal Server Error [500].');
            
              } else if (textStatus === 'parsererror') {
            
                alert('Requested JSON parse failed.');
            
              } else if (textStatus === 'timeout') {
            
                alert('Time out error.');
            
              } else if (textStatus === 'abort') {
            
                alert('Ajax request aborted.');
            
              } else {
            
                alert('Uncaught Error: ' + jqXHR.responseText);
            
              }
            
        })
        .always(function() {
            requestSent = false;
          });
    }
}