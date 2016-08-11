<?php
/**
 * @copyright	Copyright (c) 2016 I2T. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

/**
 * I2T - COMPROBANTES Helper Class.
 *
 * @package		Joomla.Site
 * @subpakage	I2T.COMPROBANTES
 */
class modCOMPROBANTESHelper {
	public function getPatametros() {
		$conf = JFactory::getConfig();
		
		$parametros = array(
			'path_ajaxphp'    => $conf->get('path_ajaxphp')
			);
		
		return $parametros;
	}
}