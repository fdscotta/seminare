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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_facturacion', JPATH_ADMINISTRATOR);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/components/com_facturacion/assets/js/form.js');


?>
</style>
<!-- para sumar totales de tabla -->
<script src="http://code.jquery.com/jquery-latest.js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/yoo_organic_demo/templates/yoo_organic/js/facturacion.js" type="text/javascript"></script>
<script src="/yoo_organic_demo/templates/yoo_organic/js/script.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="/yoo_organic_demo/templates/yoo_organic/js/jquery-1.3.2.min.js"></script>
<script language="javascript" type="text/javascript" src="/yoo_organic_demo/templates/yoo_organic/js/jquery.validate.1.5.2.js"></script>
<link href="/yoo_organic_demo/templates/yoo_organic/css/estilo.css" rel="stylesheet" type="text/css" />

<!-- validador 

  <script language="javascript" type="text/javascript" src="/yoo_organic_demo/templates/yoo_organic/js/jquery-validate.js"></script>
<script language="javascript" type="text/javascript" src="/yoo_organic_demo/templates/yoo_organic/js/jquery-validate.min.js"></script>
<script type="text/javascript">
  
  // When the browser is ready...
  $(function() {
  
    // Setup form validation on the #register-form element
    $("#frm_facturacion").validate({
    
        // Specify the validation rules
        rules: {
            id_articulo: "required"
        },
        
        // Specify the validation error messages
        messages: {
            id_articulo: "Please enter your first name"
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });

  });
  
  </script>
   <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
  <script type="text/javascript">
 $("#frm_facturacion").validate({
      rules: {
         id_articulo: {
            required: true
               }
         },
         messages: {
            id_articulo: "Required Field"
         }
     });	
  </script>
-->

<script type="text/javascript">
    getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', function() {
        jQuery(document).ready(function() {
            jQuery('#form-facturacion').submit(function(event) {
                
            });

            
        });
    });

</script>

<div class="facturacion-edit front-end-edit">
    <?php if (!empty($this->item->id)): ?>
        <h1>Editar <?php echo $this->item->id; ?></h1>
    <?php else: ?>
        <h1>Facturación</h1>
    <?php endif; ?>
<div id="totalTitulo">
<h3>Total: $</h3><h3 id="totalFacturacion_titulo">0,00</h3>
</div>
<div id="campos_facturacion">
<form action="javascript: fn_agregar();" method="post" id="frm_facturacion" name="frm_facturacion">     
  <div class="control-group">
    <label for="id_articulo" class="col-lg-2 control-label">Código del Artículo</label>
	<div class="controls">
    <input type="text" class="form-control" name="id_articulo" id="id_articulo" placeholder="Introduce el código del artículo">
  	<input type="button" class="validate btn btn-primary" id="buscar_articulo" name="buscar_articulo" onclick="Javascript:crearNuevaVentana('http://localhost/yoo_organic_demo/en/buscar');" value="Buscar"/>
	<div id="sinResultados" class="alert alert-danger" role="alert">
		<strong for="id_articulo">El codigo ingresado no pertenece a ningun articulo</strong>
	</div>
	</div>
  </div>
  <div class="control-group">
    <label for="cantidad" class="col-lg-2 control-label">Cantidad</label>
	<div class="controls">
    <input type="number" class="form-control" id="cantidad" 
           placeholder="Cantidad">
	</div>
  </div>
	<div id="articulosCompra">
	   <div class="control-group">
		<label for="descripcion" class="col-lg-2 control-label">Descripción</label>
		<div class="controls">
		<input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripción del artículo" disabled>
		</div>
	  </div> 
	   <div class="control-group">
		<label for="precio" class="col-lg-2 control-label">Precio</label>
		<div class="controls">
		<input type="number" class="form-control" id="precio" placeholder="Precio del artículo" disabled>
		</div>
	  </div>   
	  
	   <div class="control-group">
		<label for="total" class="col-lg-2 control-label">Total</label>
		<div class="controls">
		<input type="text" class="form-control" id="total" placeholder="Total ..." disabled>
		</div>
	  </div>   
	</div>   
      <div id='jqxWidget' style="font-size: 13px; font-family: Verdana; float: left;">
        <div id="jqxgrid">
        </div>
     </div>	 
	<!-- Botón para agregar filas -->
	<input name="agregar" type="button" id="agregar" value="Agregar" class="validate btn btn-primary" disabled onclick="frm_facturacion.submit()"/>
	<input type="reset" name="limpiar" id="limpiar" class="validate btn btn-primary" value="Limpiar"/>


</form>
</div>
<div id="tabla_de_facturacion">
<table id="grilla" class="lista">
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
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5"><strong>Total: $</strong> <span id="totalFacturacion">0,00</span></td>
		</tr>
		<tr>
			<td colspan="5"><strong>Cantidad:</strong> <span id="span_cantidad">4</span> articulos.</td>
		</tr>
	</tfoot>
</table>
<div id="botones_venta">
	<button class="validate btn btn-primary" id="confirmar_venta" name="confirmar_venta" value="Confirmar">Confirmar</button>
	<button class="validate btn btn-primary" id="cancelar_venta" name="limpiar_tabla" value="Limpiar">Cancelar</button>
</div>				
</div>				
</div>				


<!--
    <form id="form-facturacion" action="<?php echo JRoute::_('index.php?option=com_facturacion&task=facturacion.save'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
	
	        <div class="control-group" id="registrar_compra">
            <div class="controls">
                <button type="submit" class="validate btn btn-primary"><?php echo JText::_('JSUBMIT'); ?></button>
                <a class="btn" href="<?php echo JRoute::_('index.php?option=com_facturacion&task=facturacionform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
            </div>
        </div>
        
        <input type="hidden" name="option" value="com_facturacion" />
        <input type="hidden" name="task" value="facturacionform.save" />
        <?php echo JHtml::_('form.token'); ?>
	</form>
-->



<script language="javascript" >
var ventana;

function crearNuevaVentana(url) {

if (!ventana || ventana.closed) {
ventana = window.open(url,"sub","status,height=600,width=400, top=50, left=500");
} else if (ventana.focus) {

ventana.focus( );
}
}
</script>


<!-- Pop up Confirmar Pago  -->
<div id="popup" style="display: none;">
    <div class="content-popup">
        <div class="close"><a href="#" id="close"><img src="images/close.png"/></a></div>
        <div>
           <h2>Metodo de Pago</h2>
				<div class="total_compra">
					<h4>Total de la compra: </h4><h4 id="totalFacturacion_confirmar"></h4>
<!--					<input type="number" class="form-control" id="totalFacturacion_confirmar"  name="totalFacturacion_confirmar" value="" disabled> -->
				</div>
				<div class="control-group">
					<label for="tipo_pago" class="col-lg-2 control-label">Tipo de pago: </label>
					<div class="controls">
					<select name="tipo_pago">
						<option value="1" selected>Efectivo</option>
						<option value="">Tarjeta</option>
					</select>
					</div>
				</div>
				<div class="monto_vuelto">
					<div class="control-group mvuelto">
						<label for="monto_abonado" class="col-lg-2 control-label">Monto abonado:</label>
						<div class="controls">
							<input type="text" class="form-control" id="monto_abonado" placeholder="Cantidad de pago" >
						</div>
					</div> 
					<div class="control-group" id="vuelto_venta">
						<label class="col-lg-2 control-label">Vuelto: $</label><label class="col-lg-2 control-label" id="vuelto">0,00</label>
					</div> 
				</div> 
				<div class="confirmar">
					<button class="validate btn btn-primary" id="confirmar_pago" name="confirmar_pago" value="Confirmar">Confirmar</button>
					<button class="validate btn btn-primary" id="cancelar_pago" name="cancelar_pago" value="Cancelar">Cancelar</button>
				</div>
        </div>
    </div>
</div>
<!-- ----------------- -->