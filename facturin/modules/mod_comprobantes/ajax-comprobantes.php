<?php
define( '_JEXEC', 1 );
define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../..' ));
define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
require_once ( JPATH_CONFIGURATION   .DS.'configuration.php' );


	$id_cliente = !empty($_REQUEST['user'])?$_REQUEST['user']:0;
	$paginacion = !empty($_REQUEST['paginacion'])?$_REQUEST['paginacion']:0;
	$limite = !empty($_REQUEST['limite'])?$_REQUEST['limite']:0;
	$config = JFactory::getConfig();
	$dias_de_evaluacion = $config->get('dias_de_evaluacion');
	$host_ext = $config->get('host');
	$user_ext = $config->get('user');
	$password_ext = $config->get('password');
	$db_ext = $config->get('db');

	$option['driver']   = 'mysql';
	$option['host']     = $host_ext;    // Database host name
	$option['user']     = $user_ext;       // User for database authentication
	$option['password'] = $password_ext;   // Password for database authentication
	$option['database'] = $db_ext;      // Database name


	// 1ª consulta registros obtenidos por filtros ingresados
	$db = JDatabase::getInstance($option);
	$query	= $db->getQuery(true);
	$query = "CALL web_consulta_comprobantes('".$id_cliente."',".$dias_de_evaluacion.",".$limite.",".$paginacion.")";
	$db->setQuery($query);
	$resultados = $db->loadAssocList();

	$result = $resultados[0]['cant_registros'];

	$cantidad_total = $resultados[0]['cantidad_total'];
	if (empty($cantidad_total)) {
		$cantidad_total = 0;
	}
	$cantidad_pagina = ($paginacion/$limite) + 1;
	if (empty($cantidad_pagina)) {
		$cantidad_pagina = 0;
	}
	//arreglo de resultados y cantidad de filas
	$array =
		array (
			'resultados' => $resultados,
			'cant_registros' => $result,
			'cantidad_total' => $cantidad_total,
			'cantidad_pagina' => $cantidad_pagina
		);
	if (ob_get_length() > 0) { ob_end_clean(); }
	echo json_encode($array);
	die();
?>
