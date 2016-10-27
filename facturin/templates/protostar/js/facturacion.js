jQuery().ready(function($) {
	$("input").prop('disabled', true); 
});
jQuery(function($) {
	
	$("#user_fac").change(function(e){
		if($(this).val()== '') {
			$("input").prop('disabled', true); 
		}else{
			$("input").prop('disabled', false); 
			$("#articulosCompra input").prop('disabled', true); 
		}
	});

	$("#cancelar_venta").click(function(){
		$("#grilla tbody tr").remove();
		fn_cantidad();
		SumarColumna("grilla", 4);
	}); 

	$("#limpiar").click(function(){
		$("#agregar").prop('disabled', true); 
		$("#sinResultados").hide();	
	}); 

	$("input#id_articulo").change(function(e) {	
		// Set Search String
		var search_string = $(this).val();
		// Do Search
		buscarCodBarra(search_string);
	});

	$("input#cantidad").change(function(e) {

		document.getElementById("total").value="";
		$("#agregar").prop('disabled', true); 

		$(this).focus();

// Set Search String
var precio = document.getElementById("precio").value;
var cantidad = $(this).val();
// Do Search
if(cantidad !== ''){
	$.ajax({
		type: "POST",
		url:"/facturin/index.php?option=com_ajax&task=funcion2&format=RAW",
		cache: false,
		data: { precio: precio, cantidad:cantidad},
		dataType: "json", 
		success:function(data){
			mostrarTotal(data);
		}, 
		error: function() { alert('Se ha producido un error'); }
	});
}return false;
});

	function mostrarArticulo(data){
		if(data==""){
			var valorCampo = $("#id_articulo").val();
			$('#frm_facturacion')[0].reset();
			$('#id_articulo').focus();
			//sinResultado(valorCampo);	
		} else {
			conResultado(data);		  
		}
	}

	function buscarCodBarra(search_string){
		if(search_string !== ''){
			$.ajax({
				type: "POST",
				url:"index.php?option=com_facturacion&task=facturacionform.buscarCodBarra",
				cache: false,
				data: { query: search_string },
				dataType: "json", 
				success:function(data){
					mostrarArticulo(data);
				}, 
				error: function() { 
					mostrarArticulo("");

				}
			});
		}
	}

	function conResultado(data){
		$("#sinResultados").hide();	
		$("#descripcion").val(data.descripcion);
		$("#precio").val(data.precio); 
		$("#total").val("");		
		$("#cantidad").val("");		 
	}

	function sinResultado(valorCampo){		
		$("#sinResultados").show();
		$("#id_articulo").focus();
		$("#id_articulo").val(valorCampo);
		$("#id_articulo").select();
	};

	function mostrarTotal(data){
		if(data==""){
			document.getElementById("total").value="";
			$("#agregar").prop('disabled', true); 
		} else {
			document.getElementById("total").value=data;
			if  (( $("#descripcion").val().length > 1) && ( $("#precio").val().length > 1) && ( $("#total").val().length > 1)) {
				$("#agregar").prop('disabled', false); 
				$("#agregar").focus(); 
			} else {
				$("#agregar").prop('disabled', true); 
			}
		}
	};

// enviar datos para guardar
$("#confirmar_pago").click(function(){
// obtengo los datos de la tabla
var venta = "";
$("#grilla tbody tr").each(function (index) {
	var campo1, campo2, campo3;
	$(this).children("td").each(function (index2) {
		switch (index2) {
			case 0:
			campo1 = $(this).text();
			break;
			case 1:
			campo2 = $(this).text();
			break;
			case 2:
			campo3 = $(this).text();
			break;
			case 3:
			campo4 = $(this).text();
			break;
			case 4:
			campo5 = $(this).text();
			break;
		}
	})
// armo un array con todas las filas
var columnaTabla = campo1 + '@' + campo2 + '@' + campo3 + '@' + campo4 + '@' + campo5;
venta = columnaTabla + "//" + venta; 		
})
user_fac = $('#user_fac').val();
// Do Search
if(venta !== ''){
	$.ajax({
		type: "POST",
		url:"index.php?option=com_facturacion&task=facturacionform.confirmaVenta",
		cache: false,
		data: { query: venta, cliente:user_fac },
		dataType: "json", 
		success:function(data){
			$('#popup').fadeOut('slow');
			$('#frm_facturacion')[0].reset();
			$('tbody tr').remove();
			$('#totalFacturacion').text("0");
			$('#span_cantidad').text("0");
			$('#totalFacturacion_titulo').text("0");
			$('#id_articulo').focus();
		}, 
		error: function(data) { mostrarArticulo("");}
	});
}
return false;

});

// si presiona enter en el campo codigo de articulo
$('#id_articulo').keypress(
	function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13' && $('#id_articulo').val().length > 0){
			buscarCodBarra($('#id_articulo').val());
			$("#cantidad").focus(); 
		}else if ($('#id_articulo').val().length == 0){
			$("#limpiar").click();
		}
	}
);
// si presiona enter en el campo codigo de articulo
/*
$('#cantidad').keypress(function(event){
var keycode = (event.keyCode ? event.keyCode : event.which);
if(keycode == '13'){
if  (( $("#descripcion").val().length > 1) && ( $("#precio").val().length > 1) && ( $("#total").val().length > 1)) {
alert("habilitarlo");
$("#agregar").prop('disabled', false); 
$("#agregar").focus(); 
} else {
$("#agregar").prop('disabled', true); 
}

}
});
*/

/* confirmar pago */
	$('#confirmar_venta').click(function(){
		$('#popup').fadeIn('slow');
		$('.popup-overlay').fadeIn('slow');
		$('.popup-overlay').height($(window).height());
		return false;
	});

	$('#close, #cancelar_pago').click(function(){
		$('#monto_abonado').val('');
		$('#vuelto').val('');
		$('#vuelto_venta').hide();
		$('#popup').fadeOut('slow');
		$('.popup-overlay').fadeOut('slow');
		return false;
	});

/* calcular vuelto */
$('#monto_abonado').focusout(function(){
	calcular_vuelto($(this).val());
});

function calcular_vuelto (monto_abonado){
	$('#vuelto_venta').css('display', 'inline-block');
	var total_pagar = $("#totalFacturacion_confirmar").html();
	var total_pagado = monto_abonado;
	var vuelto = parseFloat(total_pagado) - parseFloat(total_pagar);
	$('#vuelto').html(parseFloat(vuelto));
	$('#confirmar_pago').focus();
};


});


