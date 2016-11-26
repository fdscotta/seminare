<?php
/**
 * @copyright	Copyright (c) 2015 I2T. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<script  src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
    jQuery.noConflict();
    var $j = jQuery;
  </script>
  <script  src="modules/mod_comprobantes/js/mod_comprobantes.js"></script>
  <script  src="modules/mod_comprobantes/js/mod_comprobantes_tabla.js"></script>
  <script  src="modules/mod_comprobantes/js/paginador.js"></script>
  <link rel="stylesheet" href="modules/mod_comprobantes/css/comprobantes.css" type="text/css">
<script>
$j(document).ready(function() {
    $j("#user_fac").val("456");  
    ajax(2);
});

$j(document).on('change','#user_fac',function(){
   ajax(2);
});

function reset() {
	$j('#sample_1_info').hide();
	$j('#tabla_res tbody').remove();
	$j("#paginador").hide();
}
</script>

<style>
.filtros_bus {
	width:33%;
	display:inline-table;
}
.botones_filtros {
	float:right;
}
#paginador {
	display:none;
	margin:5px;
	float:right;
}
</style>
<input id="url_path_ajaxphp" name="url_path_ajaxphp" type="hidden" value="<?php echo $parametros['path_ajaxphp'];?>">
<?php echo $parametros['usuarios'];?>
<div class="widget blue jmoddiv" >
	<div class="widget-body" style="display: block;">
		<div class="row-fluid">
			<div class="metro-nav">
				<div class="row-fluid">
          <div class="span6">
            <div class="dataTables_info" id="sample_1_info" name="sample_1_info"></div>
          </div>
					<div class="span6">
						<div id="sample_1_length" class="dataTables_length">
							<label>
								<select size="1" name="limite" id="limite" aria-controls="sample_1" class="input-mini" onchange="ajax(2);">
									<option value="5">5</option>
									<option value="10" selected="selected">10</option>
									<option value="20">20</option>
								</select>
							Resultados por p&aacute;gina
							</label>
						</div>
					</div>
				</div>
				<table class="table table-striped table-hover table-bordered dataTable " name="tabla_res" id="tabla_res">
					<thead>
						<tr>
							<th>Id</th>
							<th>Fecha</th>
							<th>Comprobantes</th>
							<th>Tipo</th>
							<th>Total</th>
              				<th></th>
						</tr>
					</thead>
				</table>
				<div class="row-fluid">
					<div class="span6 float_r">
            <div id="cantidad_pagina" name="cantidad_pagina"></div>
						<div id="paginador" name="paginador" class="dataTables_paginate paging_bootstrap pagination">
							<ul>
								<li class="prev"><a id="Atras" name="Atras" onClick="ajax(0);">← Prev</a></li>
								<li><span id="pagina" name="pagina" value=0>1</span></li>
								<li class="next"><a id="Adelante" name="Adelante" onClick="ajax(1);">Next → </a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
