//Cambia en el desplegable Pieza. 
$('#desarmar_ult_pallet_pieza').change (function () {
    var piezaId = $('#desarmar_ult_pallet_pieza').val();
    limpiar();                
    recUltPalletJson(piezaId);
});

//Recupera los datos de la pieza seleccionada
function recUltPalletJson ( piezaId ){
    
    $('#msgErrores').html('');

    //La ruta la obtiene fija desde un atributo
    var var_url = $('#rutaRecUltPalletJson').attr("ruta");

    //Reemplaza el parametro en la ruta
    var_url = var_url.replace( '-1', piezaId);
    
    $.ajax({
            url: var_url,
            type: "GET",
            dataType: "JSON",
            data: {  }
    }).done ( function (data) {    
                
                //Si tiene caja abierta
                if ( data.hasOwnProperty('CODIGO')){
                    $('#desarmar_ult_pallet_ultPalletCodigo').val(data['CODIGO']);
                    $('#desarmar_ult_pallet_ultPalletNEmbalaje').val(data['N_EMBALAJE']);
                    $('#desarmar_ult_pallet_ultPalletClienteId').val(data['COD_CLIENTE']);
                    $('#desarmar_ult_pallet_ultPalletCodIntercambio').val(data['COD_INTERCAMBIO']);
                    $('#desarmar_ult_pallet_ultPalletCantidad').val(data['CANTIDAD']);
                    $('#desarmar_ult_pallet_ultPalletUbicId').val(data['CONTENEDOR']);
                    $('#desarmar_ult_pallet_ultPalletUbicacion').val(data['ID_CONTENEDOR']);
                }
                else
                {
                    msgErrores = '<div class="alert alert-warning" role="alert"><i class="fas fa-exclamation-triangle"></i> '
                    + ' Atención!! No existe pallets para desarmar.' + 
                    '</div>';
                    $('#msgErrores').html(msgErrores);
                }

                //Habilitar boton de Armado
                //$("#btnSubmit").removeAttr("disabled", "disabled");
                //Habilitar boton de Buscar en Deposito
                $("#btnSubmit").removeAttr("disabled", "disabled");

    }).fail ( function (jqXHR, textStatus, errorThrown) {
                //alert(jqXHR.responseJSON.message);

                //DesHabilitar boton de Armado
                $("#btnSubmit").attr( "disabled", "disabled" );

                //Muestra Errores
                msgErrores = jqXHR.responseJSON['ERRORES'];
                msgErrores = '<div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-triangle"></i> '+msgErrores+'</div>';
                $('#msgErrores').html(msgErrores);

                data = jqXHR.responseJSON;

    });
    
        
}

function limpiar () 
 {
    $('#desarmar_ult_pallet_ultPalletCodigo').val('');
    $('#desarmar_ult_pallet_ultPalletNEmbalaje').val('');
    $('#desarmar_ult_pallet_ultPalletClienteId').val('');
    $('#desarmar_ult_pallet_ultPalletCodIntercambio').val('');
    $('#desarmar_ult_pallet_ultPalletCantidad').val('');
    $('#desarmar_ult_pallet_ultPalletUbicId').val('');
    $('#desarmar_ult_pallet_ultPalletUbicacion').val('');

    $('#msgErrores').html('');
 }

 //Clic en armado
$('body').on('click', '#btnSubmit', function (e) {
    //Previen el envio del form
    e.preventDefault();
    //$('#modalResultados').modal('show');
    //return;

    var ultNroPallet = $('#desarmar_ult_pallet_ultPalletNEmbalaje').val();

    var numItems = $('.embalajes').length;

    if ( !confirm('Confirma desarmar el pallet ' + ultNroPallet + '?') )
    {
        e.preventDefault();
        return false;
    }

    var_data = {  };
    
    var var_url = $('#rutaDesarmarUltPalletPost').attr("ruta");
    var var_data = $('.ajaxFormBusqueda').serialize();
    
    $.ajax({
            url: var_url,
            type: "POST",
            dataType: "JSON",
            data: var_data,
            success: function (data) {

                html = '<h4>Pallet desarmado con Exito</h4>';
                
                $('#contenidoModalResultados').html(html);

                $('#modalResultados').modal('show');

            },
            error: function (jqXHR, textStatus, errorThrown) {
                
                //Muestra Errores
                //msgErrores = jqXHR.responseJSON.message;
                msgErrores = jqXHR.responseText;
                msgErrores = '<div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-triangle"></i> '+msgErrores+'</div>';
                $('#msgErrores').html(msgErrores);

            }
    }); //fin ajax
    
}); 

//Al cerrar el modal de resultados
$('#modalResultados').on('hidden.bs.modal', function (e) {
    
    limpiar();

    $('#desarmar_ult_pallet_pieza').val(null);

    $('#desarmar_ult_pallet_pieza').focus();
 });