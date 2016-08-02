<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<dl class="search-results<?php echo $this->pageclass_sfx; ?>">
<?php foreach ($this->results as $result) : ?>
	<dt class="result-title">
		<?php echo $this->pagination->limitstart + $result->count . '. ';?>
		<?php if ($result->href) :?>
			<a href="<?php echo JRoute::_($result->href); ?>"<?php if ($result->browsernav == 1) :?> target="_blank"<?php endif;?>>
				<?php echo $this->escape($result->title);?>
			</a>
			<?php $precio = explode(" ",$result->extra_fields_search);
			$id_item = explode(":",$result->slug);?>
		  	<button class="validate btn btn-primary" id="seleccionar_art" onclick="Javascript:devolverValor(<?php echo $id_item[0] . ",'" . $result->title . "'," . $precio[2];?>);" name="seleccionar_art" value="Seleccionar">Seleccionar</button>
		<?php else:?>
			<?php echo $this->escape($result->title);?>
		<?php endif; ?>
	</dt>
	<?php if ($result->section) : ?>
		<dd class="result-category">
			<span class="small<?php echo $this->pageclass_sfx; ?>">
				(<?php echo $this->escape($result->section); ?>)
			</span>
		</dd>
	<?php endif; ?>
	<dd class="result-text">
		<?php echo $result->text; ?>
	</dd>
	<?php if ($this->params->get('show_date')) : ?>
		<dd class="result-created<?php echo $this->pageclass_sfx; ?>">
			<?php echo JText::sprintf('JGLOBAL_CREATED_DATE_ON', $result->created); ?>
		</dd>
	<?php endif; ?>
<?php endforeach; ?>
</dl>

<div class="pagination">
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>
<script language="javascript" >

function devolverValor(id,descripcion,precio) {
opener.document.forms["frm_facturacion"].id_articulo.value = id;
opener.document.forms["frm_facturacion"].descripcion.value = descripcion;
opener.document.forms["frm_facturacion"].precio.value = precio;
opener.document.forms["frm_facturacion"].cantidad.value = "";
opener.document.forms["frm_facturacion"].cantidad.focus();
opener.document.forms["frm_facturacion"].total.value = "";
opener.document.forms["frm_facturacion"].agregar.disabled = true;
window.close();
}
</script>