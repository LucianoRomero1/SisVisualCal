var requestSent = false;

function abrirEmbalajeRegPallet ( codigoEmbalajeReg, nEmbalaje){
    
    if ( !confirm('¿Seguro desea Abrir el embalaje ' + nEmbalaje + '?') )
    {
        return false;
    }

    //La ruta la obtiene fija desde un atributo
    var var_url = $('#rutaAbrirEmbalajeRegPallet').attr("ruta");

    //Reemplaza el parametro en la ruta
    var_url = var_url.replace( '-1', codigoEmbalajeReg);
    
    if (!requestSent) {
        requestSent = true;

        $.ajax({
            url: var_url,
            type: "GET",
            dataType: "JSON",
            data: {  }
        }).done ( function (data) {    
            location.reload();        
        }).fail ( function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);         
        }).always(function() {
            requestSent = false;
        });

    }
        
}

function cerrarEmbalajeRegPallet ( codigoEmbalajeReg, nEmbalaje){
    
    if ( !confirm('¿Seguro desea Cerrar el embalaje ' + nEmbalaje + '?') )
    {
        return false;
    }

    //La ruta la obtiene fija desde un atributo
    var var_url = $('#rutaCerrarEmbalajeRegPallet').attr("ruta");

    //Reemplaza el parametro en la ruta
    var_url = var_url.replace( '-1', codigoEmbalajeReg);
    
    if (!requestSent) {
        requestSent = true;

        $.ajax({
            url: var_url,
            type: "GET",
            dataType: "JSON",
            data: {  }
        }).done ( function (data) {    
            location.reload();        
        }).fail ( function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);         
        }).always(function() {
            requestSent = false;
        });

    }
        
}


requestSent = false;


function eliminaEmbalajeRegPallet ( codigoEmbalajeReg, nEmbalaje){
    
    if ( !confirm('¿Seguro desea Eliminar el embalaje ' + nEmbalaje + '?') )
    {
        return false;
    }

    //La ruta la obtiene fija desde un atributo
    var var_url = $('#rutaEliminaEmbalajeRegPallet').attr("ruta");

    //Reemplaza el parametro en la ruta
    var_url = var_url.replace( '-1', codigoEmbalajeReg);
    
    if (!requestSent) {
        requestSent = true;

        $.ajax({
            url: var_url,
            type: "GET",
            dataType: "JSON",
            data: {  }
        }).done ( function (data) {    
            location.reload();        
        }).fail ( function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseJSON['status']);         
        }).always(function() {
            requestSent = false;
        });

    }
        
}

function modificarEmbalajeRegPallet ( codigoEmbalajeReg, nEmbalaje){
    
    //La ruta la obtiene fija desde un atributo
    var var_url = $('#rutaModificarEmbalajeRegPallet').attr("ruta");

    //Reemplaza el parametro en la ruta
    var_url = var_url.replace( '-1', codigoEmbalajeReg);
    
    if (!requestSent) {
        requestSent = true;

        $.ajax({
            url: var_url,
            type: "GET",
            data: {  }
        }).done ( function (data) {    
            var titulo = "Modificar Embalaje  "+nEmbalaje;
            $("#me-name-header-modal-view").html(titulo);
            $("#me-text-header-body-view").html(data);
            $('#modificarEmbalajeRegPalletModal').modal('show');

        }).fail ( function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);         
        }).always(function() {
            requestSent = false;
        });

    }
        
}

function imprimirEtiquetas()
{

    if ( !confirm('¿Seguro desea Imprimir los embalajes seleccionados.') )
    {
        return false;
    }

    var checkboxs = document.getElementsByClassName("check-all");
    var var_json = ' { "embalajesRegs" : [ ';
    var j = 0;
    for (var i = 0, l = checkboxs.length; i < l; i++)
    {

        if (checkboxs[i].checked && (checkboxs[i]).value != "-1" )
        {
            if ( j > 0) 
            {
                var_json = var_json + ', ';
            }
            var_json = var_json + ' { "id" : ' + checkboxs[i].value + '}';
            j++;

        }
    }
    var_json = var_json + ' ] }';

    var var_url = $('#rutaImprimirPallet').attr("ruta");

    if ( j == 0 )
    {
        alert('Debe Selecionar al menos un Pallet.');
        return false;
    }

    if (!requestSent) {
        requestSent = true;

        $.ajax({
            url: var_url,
            type: "POST",
            dataType: "JSON",
            data: var_json
        }).done ( function (data) {    
            for(var i = data['embalajesRegs'].length -1;i>=0;i--){
                l_array = data['embalajesRegs'][i];

                var li_return = writeToSelectedPrinter( l_array['cmdZPL'] );

                if ( li_return == 1 )
                {
                    palletSetImpreso( l_array['id'] );
                }
                                
            };
            //location.reload();  
        }).fail ( function (jqXHR, textStatus, errorThrown) {
            alert('imprimirEtiquetas ' + jqXHR.responseText);         
        }).always(function() {
            requestSent = false;
        });

    }

}

function palletSetImpreso( $embalajeRegId )
{
    var var_url = $('#rutaPalletSetImpreso').attr("ruta");

    var var_json = '{ "embalajesRegs" : [ {"id" : ' + $embalajeRegId + ' } ] }';

    $.ajax({
        url: var_url,
        type: "POST",
        dataType: "JSON",
        data: var_json
    }).done ( function (data) {    
        
    }).fail ( function (jqXHR, textStatus, errorThrown) {
        alert('palletSetImpreso' + jqXHR.responseText);         
    }).always(function() {
        requestSent = false;
    });
}

function imprimirEtiquetasGrandes()
{

    if ( !confirm('¿Seguro desea Imprimir los embalajes seleccionados? (Hoja A4)') )
    {
        return false;
    }

    var checkboxs = document.getElementsByClassName("check-all");
    var j = 0;

    var callback = function() {
        //alert("done");
        location.reload();
    };  
    var requests = [];
    for (var i = 0, l = checkboxs.length; i < l; i++)
    {


        if (checkboxs[i].checked && (checkboxs[i]).value != "-1" )
        {
            j++;
            var_url = $('#rutaImprimirPalletGr').attr("ruta");
            var_url = var_url.replace( '-1', checkboxs[i].value);

            requests.push(
                $.ajax({
                    url: var_url,
                    type: "GET",
                    data: {}
                }).done ( function (data) {    
                    window.open(data.message, '_blank');
                }).fail ( function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);         
                }).always(function() {
                    requestSent = false;
                })
            );//fin push

        }
    }


    $.when.apply(undefined, requests).then(function(results){callback()});


    if ( j == 0 )
    {
        alert('Debe Selecionar al menos un Pallet.');
        return false;
    }

    //location.reload();

}