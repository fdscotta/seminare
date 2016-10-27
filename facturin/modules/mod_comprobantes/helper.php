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
			'path_ajaxphp'    => $conf->get('path_ajaxphp'),
			'usuarios'    => $this->getListaUsuarios("")
			);
		

		return $parametros;
	}


	public function getListaUsuarios($tipo_user){ 

	// Get a db connection.
	    $db = JFactory::getDbo();

	// Create a new query object.
	    $query = $db->getQuery(true);

	// Select all records from the user profile table where key begins with "custom.".
	// Order it by the ordering field.
	    $query->select($db->quoteName(array('a.id','a.name')));
	    $query->from($db->quoteName('#__users','a'));
	    $query->join('INNER', $db->quoteName('#__user_usergroup_map', 'b') . ' ON (' . $db->quoteName('a.id') . ' = ' . $db->quoteName('b.user_id') . ')');
	    $query->join('INNER', $db->quoteName('#__usergroups', 'c') . ' ON (' . $db->quoteName('b.group_id') . ' = ' . $db->quoteName('c.id') . ')');
	    $query->where('UPPER('.$db->quoteName('title').')' . ' = UPPER("clientes")');

	// Reset the query using our newly populated query object.
	    $db->setQuery($query);
        
        $rows = $db->loadObjectList();

        $options[] = JHTML::_('select.option','','Seleccione uno...');
        foreach ($rows as $key => $value) {
            $options[] = JHTML::_('select.option', $value->id, JText::_($value->name));     
        }
	// Load the results as a list of stdClass objects (see later for more options on retrieving data).
	   // $results = $db->loadAssocList();

	    if($rows){
			return  JHTML::_('select.genericlist', $options, 'user_fac', 'class = "user_fac"', 'value','text', 'Seleccione uno...' );	    
		} 

	}   

}