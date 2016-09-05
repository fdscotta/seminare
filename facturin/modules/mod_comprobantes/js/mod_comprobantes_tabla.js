function llenar_tabla_comprobantes(data) {
	$j('#tabla_res tbody').remove();
	codigo_tabla = "<tbody>"
	contador = 0;
	data.length;
	$j.each( data, function( i, val ) {
		codigo_tabla = codigo_tabla+"<tr><td>"+val.fecha_emicion+"</td>";
		codigo_tabla = codigo_tabla+"<td><a href='' title='Ver Cliente'>"+val.name+"</a></td>";
		codigo_tabla = codigo_tabla+"<td>"+val.id_tipo_comp+"</td>";
		codigo_tabla = codigo_tabla+"<td class='importe_r'>$"+val.total+"</td>";
		codigo_tabla = codigo_tabla+"<td style='text-align: center;'><div><a href='index.php?option=com_facturacion&task=facturacionform.bajaComprobante&id_comp=1' title='Dar de Baja'  target='_self'><i class='icon-remove'></i></a>";
		codigo_tabla = codigo_tabla+"<a href='' title='Ver Comprobante'  target='_blank'><i class='icon-search'></i></a></div>";
		codigo_tabla = codigo_tabla+"</td></tr>";
	});
	codigo_tabla = codigo_tabla+"</tbody>";
	$j("#tabla_res").append(codigo_tabla);
	$j("#tabla_res").fadeIn("slow"); 
}
