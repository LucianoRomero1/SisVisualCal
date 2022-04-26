$("#ry_r_soloPdf").click( function(){

    mostrarOcultarDiv( $(this).is(':checked') );
    //if( $(this).is(':checked') )
    //{
    //    $("#conPdf").removeClass('d-none');
    //    $("#sinPdf").addClass('d-none');
    //} else {
    //    $("#sinPdf").removeClass('d-none');
    //    $("#conPdf").addClass('d-none');
    //    $("#ry_r_rutaArchivo").val('');
    //}

 });

 $(function() {
    $('#jsRutaArchivo').change(function(){
        $("#ry_r_rutaArchivo").val(this.value);
        console.log(this.files);
    });
})

function mostrarOcultarDiv( lb_){
    if( lb_ )
    {
        $("#conPdf").removeClass('d-none');
        $("#sinPdf").addClass('d-none');
    } else {
        $("#sinPdf").removeClass('d-none');
        $("#conPdf").addClass('d-none');
        $("#ry_r_rutaArchivo").val('');
    }    
}

function calcularRyR(){
    
    var operadores =  $("#ry_r_ops").val();
    if ( operadores==="" || operadores=="0") {
        alert('Debe ingresar la cantidad de operadores.');
        return false;
    }

    var pruebas =  $("#ry_r_trials").val();
    if ( pruebas==="" || pruebas=="0") {
        alert('Debe ingresar la cantidad de Pruebas.');
        return false;
    }

    if ( $("#ry_r_usl").val()==="" || $("#ry_r_usl").val()=="0") {
        alert('Debe ingresar límite superior válido.');
        return false;
    }

    if ( $("#ry_r_lsl").val()==="" || $("#ry_r_lsl").val()=="0") {
        alert('Debe ingresar límite inferior válido.');
        return false;
    }

    operadores = Number( operadores);
    pruebas = Number ( pruebas);

    //Genera array dimensionado 
    var ll_array_a = new Array (operadores );

    for (var i = 0; i < ll_array_a.length; i++) {
        
        ll_array_a[i] = new Array(pruebas );
        
        for ( var j = 0; j < ll_array_a[i].length; j++) {
            ll_array_a[i][j] = new Array(10);
        }
    }
    
    //console.log( ll_array_a);
    for(var ll_o = 0; ll_o < operadores; ll_o++)
     {
        for ( var ll_p = 0; ll_p < pruebas; ll_p++ )
        {
            for ( var ll_i = 0; ll_i< 10; ll_i++ )
            {
                var campo = 'ry_r_';
                if ( ll_o == 0) {
                    campo = campo + 'a';
                }else if (ll_o == 1) {
                    campo = campo + 'b';
                }else {
                    campo = campo + 'c';
                }
                
                campo = campo + ( ll_p + 1).toString() + (ll_i + 1).toString();

                if ( $('#' + campo).val() == "" ){
                    alert('Debe ingresar valores válidos en los operadores.');
                    return;
                }

                ll_array_a[ll_o][ll_p][ll_i] = parseFloat( $('#' + campo).val());
            }
        }
    }
    console.log( "array_a");
    console.log( ll_array_a);

    //Genera array dimensionado 
    var ll_array_b = new Array (operadores );

    //por cada operador
    for (var ll_o = 0; ll_o < ll_array_b.length; ll_o++) {
        ll_array_b[ll_o] = new Array(1);
        ll_array_b[ll_o][0] = new Array(10);    
    }

    //por cada operador
    for (var ll_o = 0; ll_o < ll_array_b.length; ll_o++) {
        
        for ( var ll_i = 0; ll_i< 10; ll_i++ ){
            var max_op_i = -999;
            var min_op_i = 999;
            for ( var ll_p = 0; ll_p < pruebas; ll_p++ ) {
                if ( ll_array_a[ll_o][ll_p][ll_i] > max_op_i ) { max_op_i = ll_array_a[ll_o][ll_p][ll_i];}
                if ( ll_array_a[ll_o][ll_p][ll_i] < min_op_i ) { min_op_i = ll_array_a[ll_o][ll_p][ll_i];}
            }

            ll_array_b[ll_o][0][ll_i] = parseFloat((max_op_i - min_op_i).toFixed(4));
        }
    }
    console.log( "array_b");
    console.log( ll_array_b);

    var array_rangos_x = new Array( operadores);
    for (var ll_o = 0; ll_o < array_rangos_x.length; ll_o++) {
        var aux_sum = 0;
        for ( var ll_i = 0; ll_i< 10; ll_i++ ){
            aux_sum = aux_sum + ll_array_b[ll_o][0][ll_i];
        }
        array_rangos_x[ll_o] = aux_sum / 10;
    }

    console.log( "array_rangos_x");
    console.log( array_rangos_x);

    var array_prom_valv = new Array(10);
    for ( var ll_i = 0; ll_i< 10; ll_i++ ){
        var aux_sum = 0;

        for(var ll_o = 0; ll_o < operadores; ll_o++) {
            for ( var ll_p = 0; ll_p < pruebas; ll_p++ ){
                aux_sum = aux_sum + ll_array_a[ll_o][ll_p][ll_i];
            }
        }

        array_prom_valv[ll_i] = parseFloat( (aux_sum / (ll_o * ll_p)).toFixed(6)) ;
    }

    console.log( "array_prom_valv");
    console.log( array_prom_valv);
    
    var array_x_mediciones = new Array(operadores);

    for(var ll_o = 0; ll_o < operadores; ll_o++) {
        var aux_sum = 0;

        for ( var ll_p = 0; ll_p < pruebas; ll_p++ ){
            for ( var ll_i = 0; ll_i< 10; ll_i++ ){
                aux_sum = aux_sum + ll_array_a[ll_o][ll_p][ll_i];
            }
        }

        array_x_mediciones[ll_o] = parseFloat( (aux_sum / ( 10 * pruebas)).toFixed(6));
    }

    console.log( "array_x_mediciones");
    console.log( array_x_mediciones);

    var ldec_rango_x_mediciones = 0.0;

    var max_op_i = -999;
    var min_op_i = 999;
    for(var ll_o = 0; ll_o < operadores; ll_o++) {
        if ( array_x_mediciones[ll_o] > max_op_i ) { max_op_i = array_x_mediciones[ll_o];}
        if ( array_x_mediciones[ll_o] < min_op_i ) { min_op_i = array_x_mediciones[ll_o];}
    }

    ldec_rango_x_mediciones = parseFloat( (max_op_i - min_op_i).toFixed(6));
    console.log( "ldec_rango_x_mediciones");
    console.log( ldec_rango_x_mediciones);

    var max_op_i = -999;
    var min_op_i = 999;
    for ( var ll_i = 0; ll_i< 10; ll_i++ ){
        if ( array_prom_valv[ll_i] > max_op_i ) { max_op_i = array_prom_valv[ll_i];}
        if ( array_prom_valv[ll_i] < min_op_i ) { min_op_i = array_prom_valv[ll_i];}
    }

    var ldec_rp = parseFloat( (max_op_i - min_op_i).toFixed(6));

    console.log( "ldec_rp");
    console.log( ldec_rp);

    var array_tabla_1 = new Array (3);
    var array_tabla_2 = new Array (10);
    var array_tabla_3 = new Array (10);

    array_tabla_1[0] = 0;
    array_tabla_1[1] = 4.56;
    array_tabla_1[2] = 3.05;
    console.log( "array_tabla_1");
    console.log( array_tabla_1);

    array_tabla_2[0] = 0;
    array_tabla_2[1] = 3.65;
    array_tabla_2[2] = 2.7;
    array_tabla_2[3] = 2.3;
    array_tabla_2[4] = 2.08;
    array_tabla_2[5] = 1.93;
    array_tabla_2[6] = 1.82;
    array_tabla_2[7] = 1.74;
    array_tabla_2[8] = 1.67;
    array_tabla_2[9] = 1.62;
    console.log( "array_tabla_2");
    console.log( array_tabla_2);

    array_tabla_3[0] = 0;
    array_tabla_3[1] = 3.267;
    array_tabla_3[2] = 2.574;
    array_tabla_3[3] = 2.282;
    array_tabla_3[4] = 2.114;
    array_tabla_3[5] = 2.004;
    array_tabla_3[6] = 1.924;
    array_tabla_3[7] = 1.864;
    array_tabla_3[8] = 1.816;
    array_tabla_3[9] = 1.777;
    console.log( "array_tabla_3");
    console.log( array_tabla_3);

    var aux_sum = 0;
    for (var ll_o = 0; ll_o < array_rangos_x.length; ll_o++) {
        aux_sum = aux_sum + array_rangos_x[ll_o];
    }

    var ldec_tol = Math.abs(parseFloat( $('#ry_r_usl').val()) - parseFloat($('#ry_r_lsl').val()));
    console.log( "ldec_tol");
    console.log( ldec_tol);

    var ldec_vt_barra_r = aux_sum / array_rangos_x.length;
    console.log( "ldec_vt_barra_r");
    console.log( ldec_vt_barra_r);

    var ldec_vt_lsc_r = ldec_vt_barra_r * array_tabla_3[ pruebas - 1 ];
    console.log( "ldec_vt_lsc_r");
    console.log( ldec_vt_lsc_r);

    var ldec_rep_ve = ldec_vt_barra_r * array_tabla_1[ pruebas - 1 ];
    console.log( "ldec_rep_ve");
    console.log( ldec_rep_ve);

    var ldec_rep_porc_tol = ldec_rep_ve / ldec_tol;
    console.log( "ldec_rep_porc_tol");
    console.log( ldec_rep_porc_tol);

    var ldec_va =   Math.pow(ldec_rango_x_mediciones * array_tabla_2[ operadores - 1], 2)
                    -
                    Math.pow(ldec_rep_ve , 2)
                    /
                    ( 10 * pruebas);
    console.log( "ldec_va");
    console.log( ldec_va);

    var ldec_repro_veval = 0.0;
    if ( ldec_va > 0 ) {
        ldec_repro_veval= Math.sqrt(ldec_va);
    }
    
    console.log( "ldec_repro_veval");
    console.log( ldec_repro_veval);

    var ldec_repro_porc_tol = ldec_repro_veval / ldec_tol;
    console.log( "ldec_repro_porc_tol");
    console.log( ldec_repro_porc_tol);

    var ldec_vp = ldec_rp * array_tabla_2[10 - 1];
    console.log( "ldec_vp");
    console.log( ldec_vp);

    var ldec_vp_porc_tol = ldec_vp / ldec_tol;
    console.log( "ldec_vp_porc_tol");
    console.log( ldec_vp_porc_tol);

    var ldec_ryr = Math.sqrt ( Math.pow ( ldec_rep_ve , 2 ) + Math.pow( ldec_repro_veval , 2) );
    console.log( "ldec_ryr");
    console.log( ldec_ryr);

    var ldec_ryr_porc_tol = ldec_ryr / ldec_tol;
    console.log( "ldec_ryr_porc_tol");
    console.log( ldec_ryr_porc_tol);

    var ldec_vt = Math.sqrt ( Math.pow ( ldec_ryr , 2 ) + Math.pow( ldec_vp , 2) );
    console.log( "ldec_vt");
    console.log( ldec_vt);

    var ldec_rep_porc_tv = ldec_rep_ve / ldec_vt;
    console.log( "ldec_rep_porc_tv");
    console.log( ldec_rep_porc_tv);

    var ldec_repro_porc_tv = ldec_repro_veval / ldec_vt;
    console.log( "ldec_repro_porc_tv");
    console.log( ldec_repro_porc_tv);

    var ldec_vp_porc_tv = ldec_vp / ldec_vt;
    console.log( "ldec_vp_porc_tv");
    console.log( ldec_vp_porc_tv);

    var ldec_ryr_porc_tv = ldec_ryr / ldec_vt;
    console.log( "ldec_ryr_porc_tv");
    console.log( ldec_ryr_porc_tv);

    //mostrar en pantalla
    $('#ry_r_ev').val(ldec_rep_ve.toFixed(4));
    $('#ry_r_evtolPorc').val( (ldec_rep_porc_tol * 100).toFixed(1) );
    $('#ry_r_evtvPorc').val((ldec_rep_porc_tv * 100).toFixed(1));

    $('#ry_r_av').val(ldec_repro_veval.toFixed(4));
    $('#ry_r_avtolPorc').val((ldec_repro_porc_tol * 100).toFixed(1));
    $('#ry_r_avtvPorc').val((ldec_repro_porc_tv * 100).toFixed(1));

    $('#ry_r_pv').val(ldec_vp.toFixed(4));
    $('#ry_r_pvtolPorc').val((ldec_vp_porc_tol * 100).toFixed(1));
    $('#ry_r_pvtvPorc').val((ldec_vp_porc_tv * 100).toFixed(1));

    $('#ry_r_rBar').val(ldec_vt_barra_r.toFixed(4));
    $('#ry_r_uclR').val(ldec_vt_lsc_r.toFixed(4));
    $('#ry_r_tv').val(ldec_vt.toFixed(4));

    $('#ry_r_rr').val(ldec_ryr.toFixed(4));
    $('#ry_r_rrtolPorc').val((ldec_ryr_porc_tol * 100).toFixed(1));
    $('#ry_r_rrtvPorc').val((ldec_ryr_porc_tv * 100).toFixed(1));
}


