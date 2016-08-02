<?php
jimport('joomla.application.component.controller');
class ajaxController extends JControllerLegacy
{
	//constructor
	function __construct($config = array())
	{
		parent::__construct($config);
	}
	//a partir de aqui las funciones ajax
	// Busco un articulo
	function funcion1()
	{
		$codigo_barra = $_REQUEST['query'];
		
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		 
		// Select all records from the user profile table where key begins with "custom.".
		// Order it by the ordering field.
		$query->select($db->quoteName(array('id','title','extra_fields')));
		$query->from($db->quoteName('#__k2_items'));
		$query->where($db->quoteName('id') . ' = ' . $codigo_barra);

		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		 
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadRow();
			
		if($results){
			$JSON =  $results[2];	// los campos extra los decodifico	

			$obj = json_decode($JSON); 
			$array = array(
				'descripcion' => $obj[0]->value,
				'val' => $obj[1]->value,
				'precio' => $obj[3]->value
			);
			echo json_encode($array); // encontro un articulo
		} else {
			echo json_encode("");	// no encontro ningun articulo
		}
	}
	
	// Calculo el total
	function funcion2()
	{
		$precio = $_REQUEST['precio'];

		$cantidad = $_REQUEST['cantidad'];

		$total = $precio * $cantidad;
		
		if ($total){
			echo json_encode($total);		
		} else {
			echo json_encode("");	
		}

	
	}
	
}
?>