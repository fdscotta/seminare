function llenar_tabla_comprobantes(data) {
	$j('#tabla_res tbody').remove();
	codigo_tabla = "<tbody>"
	contador = 0;
	data.length;
	$j.each( data, function( i, val ) {
		codigo_tabla = codigo_tabla+"<tr><td>"+val.id_comprobante+"</td>";
		codigo_tabla = codigo_tabla+"<td>"+val.fecha_emicion+"</td>";
		codigo_tabla = codigo_tabla+"<td><a href='' title='Ver Cliente'>"+val.name+"</a></td>";
		codigo_tabla = codigo_tabla+"<td>"+val.id_tipo_comp+"</td>";
		codigo_tabla = codigo_tabla+"<td class='importe_r'>$"+val.total+"</td>";
		codigo_tabla = codigo_tabla+"<td style='text-align: center;'><div>";
		if(val.id_tipo_comp == "Venta"){
			codigo_tabla = codigo_tabla+"<a href='/facturin/index.php?option=com_facturacion&task=facturacionform.bajaComprobante&id_comp="+val.id_comprobante+"' title='Dar de Baja'  target='_self'><i class='icon-remove'></i></a>";
		}
		codigo_tabla = codigo_tabla+"<a href='/facturin/index.php?option=com_facturacion&view=facturacion&id="+val.id_comprobante+"&id_tip="+val.id_tip+"' title='Ver Comprobante'  target='_blank'><i class='icon-search'></i></a></div>";
		codigo_tabla = codigo_tabla+"</td></tr>";
	});
	codigo_tabla = codigo_tabla+"</tbody>";
	$j("#tabla_res").append(codigo_tabla);
	$j("#tabla_res").fadeIn("slow"); 
}
