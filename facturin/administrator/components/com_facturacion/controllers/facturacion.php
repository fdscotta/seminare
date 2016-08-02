<?php
/**
 * @version     1.0.0
 * @package     com_facturacion
 * @copyright   Copyright (C) 2014. Todos los derechos reservados.
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 * @author      Andrés Müller <andres.muller99@gmail.com> - http://
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Facturacion controller class.
 */
class FacturacionControllerFacturacion extends JControllerForm
{

    function __construct() {
        $this->view_list = 'facturacions';
        parent::__construct();
    }

}