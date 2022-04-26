var requestSent = false;

function abrirEmbalajeRegCaja ( codigoEmbalajeReg, nEmbalaje){
    
    if ( !confirm('¿Seguro desea Abrir el embalaje ' + nEmbalaje + '?') )
    {
        return false;
    }

    //La ruta la obtiene fija desde un atributo
    var var_url = $('#rutaAbrirEmbalajeRegCaja').attr("ruta");

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

function cerrarEmbalajeRegCaja ( codigoEmbalajeReg, nEmbalaje){
    
    if ( !confirm('¿Seguro desea Cerrar el embalaje ' + nEmbalaje + '?') )
    {
        return false;
    }

    //La ruta la obtiene fija desde un atributo
    var var_url = $('#rutaCerrarEmbalajeRegCaja').attr("ruta");

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

function extraerGranelEmbalajeRegCaja ( codigoEmbalajeReg, nEmbalaje){
    
    if ( !confirm('¿Seguro desea Extraer unidades del embaleje ' + nEmbalaje + '?') )
    {
        return false;
    }

    //La ruta la obtiene fija desde un atributo
    var var_url = $('#rutaExtraerGranelEmbalajeRegCaja').attr("ruta");

    //Reemplaza el parametro en la ruta
    var_url = var_url.replace( '-1', codigoEmbalajeReg);
    
    if (!requestSent) {
        requestSent = true;

        $.ajax({
            url: var_url,
            type: "GET",
            data: {  }
        }).done ( function (data) {    
            var titulo = "Extraer Granel desde  "+nEmbalaje;
            $("#eg-name-header-modal-view").html(titulo);
            $("#eg-text-header-body-view").html(data);
                
                //2-completa en el modal los nombres de los input que van a actualizarse
                //$('#cuotaPend_campos_actualizar').attr("campo0", campos[0]);
               //$('#cuotaPend_campos_actualizar').attr("campo1", campos[1]);
                //$('#cuotaPend_campos_actualizar').attr("campo2", campos[2]);
                
                
            $('#extraerGranelModal').modal('show');        
        }).fail ( function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);         
        }).always(function() {
            requestSent = false;
        });

    }
        
}

requestSent = false;

//Es llamada al cerrar el modal. Desde extraerGranel.html.twig
function extraerGranelPost (var_json)
{
        if (!requestSent) {
            requestSent = true;
            var var_url = $('#rutaExtraerGranelEmbalajeRegCajaPost').attr("ruta");
            $.ajax({
                url: var_url,
                type: "POST",
                dataType: "JSON",
                data: var_json
            }).done ( function (data) {    
                location.reload();        
            }).fail ( function (jqXHR, textStatus, errorThrown) {
                //alert(jqXHR.responseText);         
                alert( jqXHR.responseJSON['status']);
            }).always(function() {
                requestSent = false;
            });
        }
}

function eliminaEmbalajeRegCaja ( codigoEmbalajeReg, nEmbalaje){
    
    if ( !confirm('¿Seguro desea Eliminar el embalaje ' + nEmbalaje + '?') )
    {
        return false;
    }

    //La ruta la obtiene fija desde un atributo
    var var_url = $('#rutaEliminaEmbalajeRegCaja').attr("ruta");

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

function modificarEmbalajeRegCaja ( codigoEmbalajeReg, nEmbalaje){
    
    //La ruta la obtiene fija desde un atributo
    var var_url = $('#rutaModificarEmbalajeRegCaja').attr("ruta");

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
            $('#modificarEmbalajeRegCajaModal').modal('show');

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

    var var_url = $('#rutaImprimirCaja').attr("ruta");

    if ( j == 0 )
    {
        alert('Debe Selecionar al menos una caja.');
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

                if ( l_array['ESTADO'] == 'ABIERTO')
                {
                    alert('Atención, las cajas abiertas tienen formato especial.')
                    var li_return = writeToSelectedPrinter( l_array['cmdZPL'] );
                }
                else
                { 
                    var li_return = writeToSelectedPrinter( l_array['cmdZPL'] );

                    if ( li_return == 1 )
                    {
                        cajaSetImpreso( l_array['id'] );
                    }
                }

                //alert( l_array['cmdZPL'] );
            };
            //location.reload();  
        }).fail ( function (jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);         
        }).always(function() {
            requestSent = false;
        });

    }

}

function cajaSetImpreso( $embalajeRegId )
{
    var var_url = $('#rutaCajaSetImpreso').attr("ruta");

    var var_json = '{ "embalajesRegs" : [ {"id" : ' + $embalajeRegId + ' } ] }';

    $.ajax({
        url: var_url,
        type: "POST",
        dataType: "JSON",
        data: var_json
    }).done ( function (data) {    
        
    }).fail ( function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);         
    }).always(function() {
        requestSent = false;
    });
}