<?php
/**
 * @version     1.0.0
 * @package     com_facturacion
 * @copyright   Copyright (C) 2014. Todos los derechos reservados.
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 * @author      Andrés Müller <andres.muller99@gmail.com> - http://
 */
// no direct access
defined('_JEXEC') or die;

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_facturacion', JPATH_ADMINISTRATOR);

?>
<?php if ($this->item) : ?>
	<div class="col-xs-12">
		<div class="col-xs-6">
			<span>ID: </span><span><?php echo $this->item->id_comprobante;?></span>
		</div>
		<div class="col-xs-6">
			<span>Tipo de Comprobante: </span><span><?php echo $this->item->id_tipo_comp;?></span>
		</div>
		<div class="col-xs-6">
			<span>Fecha: </span><span><?php echo $this->item->fecha_emicion;?></span>
		</div>
		<div class="col-xs-6" style="display: none;">
			<span>Cliente/Proveedor: </span><span><?php echo $this->item->id_proveedor;?></span>
		</div>
		<div class="col-xs-6" style="display: none;">
			<span>Usuario: </span><span><?php echo $this->item->cliente;?></span>
		</div>
	</div>
	<div id="tabla_de_facturacion">
		<table id="grilla" class="lista  col-xs-12">
			<thead>
				<tr>
					<th>Código</th>
					<th>Descripción</th>
					<th>Cantidad</th>
					<th>Precio</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($this->item_det as $key => $value) {
				echo "<tr>";
				echo "<th>".$value->id_articulo."</th>";
				echo "<th>Descripcion del articulo</th>";
				echo "<th>".$value->cantidad."</th>";
				echo "<th>".$value->precio."</th>";
				echo "<th>".$value->total."</th>";
				echo "<td style='text-align: center;'><div>";
				echo "</div></td>";		
				echo "</tr>";
			}?>
			</tbody>
			<tfoot>
				<tr>
					<td><strong>Total: $</strong> <span id="totalFacturacion"><?php echo $this->item->total;?></span></td>
				</tr>
				<tr>
					<td><strong>Cantidad:</strong> <span id="span_cantidad"><?php echo count($this->item_det);?></span> articulos.</td>
				</tr>
			</tfoot>
		</table>
    </div>
    <?php
else:
    echo JText::_('COM_FACTURACION_ITEM_NOT_LOADED');
endif;
?>
