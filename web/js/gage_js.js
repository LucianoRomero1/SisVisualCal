$("#gage_id").change(
	function(){
	   //alert('hola');
	   //La ruta la obtiene fija desde un atributo
	   var var_url = $('#rutaObtenerDatosGage').attr("ruta");
	   
	   //Reemplaza el parametro en la ruta
	   var_url = var_url.replace( '-1', $("#gage_id").val() );
	   
	   $.ajax({
		   url: var_url,
		   type: "GET",
		   dataType: "JSON",
		   data: {  },
		   success: function (data) {
			   if (data == null) {
				   //ok, No existe
			   }else{
				   alert('El Instrumento ingresado ya existe.');
				   $("#gage_id").val('');
			   }
		   }
	   });
	}
);