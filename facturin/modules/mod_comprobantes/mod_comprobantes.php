<?php
/**
 * @copyright	@copyright	Copyright (c) 2016 I2T. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

// include the syndicate functions only once
require_once __DIR__ . '/helper.php';
$feed = new modCOMPROBANTESHelper();
$parametros = $feed->getPatametros();

$class_sfx = htmlspecialchars($params->get('class_sfx'));

require(JModuleHelper::getLayoutPath('mod_comprobantes', $params->get('layout', 'default')));