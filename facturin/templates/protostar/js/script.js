// JavaScript Document

            jQuery(document).ready(function(){
                fn_dar_eliminar();
				fn_cantidad();
            //    $("#frm_facturacion").validate();
            });
			
			function fn_cantidad(){
				cantidad = $("#grilla tbody tr").length;
				$("#span_cantidad").html(cantidad);
			};
            
            function fn_agregar(){
                cadena = "<tr>";
                cadena = cadena + "<td>" + $("#codigo").val() + "</td>";
                cadena = cadena + "<td>" + $("#descripcion").val() + "</td>";
                cadena = cadena + "<td>" + $("#cantidad").val() + "</td>";
                cadena = cadena + "<td>" + $("#precio").val() + "</td>";
                cadena = cadena + "<td>" + $("#total").val() + "</td>";
                cadena = cadena + "<td><a class='elimina'><img src='../images/delete.png' /></a></td>";
                $("#grilla tbody").append(cadena);
                /*
                    aqui puedes enviar un conunto de tados ajax para agregar al usuairo
                    $.post("agregar.php", {ide_usu: $("#valor_ide").val(), nom_usu: $("#valor_uno").val()});
                */
                fn_dar_eliminar();
				fn_cantidad();
				SumarColumna("grilla", 4);
				$('#frm_facturacion')[0].reset();
				$("#id_articulo").focus();
				$("#agregar").prop('disabled', true);
            //    alert("Articulo agregado");
            };
            
             function fn_dar_eliminar(){
                $("a.elimina").click(function(){
                    id = $(this).parents("tr").find("td").eq(0).html();
                    respuesta = confirm("Desea eliminar el artículo: " + id);
                    if (respuesta){
                        $(this).parents("tr").fadeOut("normal", function(){
                            $(this).remove();
                            alert("Artículo " + id + " eliminado");
							fn_cantidad();
							SumarColumna("grilla", 4);
                            /*
                                aqui puedes enviar un conjunto de datos por ajax
                                $.post("eliminar.php", {ide_usu: id})
                            */
                        })
                    }
                });
            };

function SumarColumna(grilla, columna) {
 
    var resultVal = 0.0; 
         
    $("#" + grilla + " tbody tr").each(
        function() {
         
            var celdaValor = $(this).find('td:eq(' + columna + ')');
            
            if (celdaValor.val() != null)
                    resultVal += parseFloat(celdaValor.html().replace(',','.'));
                     
        } //function
         
    ) //each
    
    $("#totalFacturacion").html(resultVal.toFixed(2).toString().replace('.',','));   
    $("#totalFacturacion_titulo").html(resultVal.toFixed(2).toString().replace('.',','));   
    $("#totalFacturacion_confirmar").html(resultVal.toFixed(2).toString().replace('.',','));   
 
} 			
