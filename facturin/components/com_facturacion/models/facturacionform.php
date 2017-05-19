<?php
/**
 * @version     1.0.0
 * @package     com_facturacion
 * @copyright   Copyright (C) 2014. Todos los derechos reservados.
 * @license     Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 * @author      Andrés Müller <andres.muller99@gmail.com> - http://
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

/**
 * Facturacion model.
 */
class FacturacionModelFacturacionForm extends JModelForm
{
    
    var $_item = null;
    
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('com_facturacion');

		// Load state from the request userState on edit or from the passed variable on default
        if (JFactory::getApplication()->input->get('layout') == 'edit') {
            $id = JFactory::getApplication()->getUserState('com_facturacion.edit.facturacion.id');
        } else {
            $id = JFactory::getApplication()->input->get('id');
            JFactory::getApplication()->setUserState('com_facturacion.edit.facturacion.id', $id);
        }
		$this->setState('facturacion.id', $id);

		// Load the parameters.
        $params = $app->getParams();
        $params_array = $params->toArray();
        if(isset($params_array['item_id'])){
            $this->setState('facturacion.id', $params_array['item_id']);
        }
		$this->setState('params', $params);

	}
        

	/**
	 * Method to get an ojbect.
	 *
	 * @param	integer	The id of the object to get.
	 *
	 * @return	mixed	Object on success, false on failure.
	 */
	public function &getData($id = null)
	{
		if ($this->_item === null)
		{
			$this->_item = false;

			if (empty($id)) {
				$id = $this->getState('facturacion.id');
			}

			// Get a level row instance.
			$table = $this->getTable();

			// Attempt to load the row.
			if ($table->load($id))
			{
                
                $user = JFactory::getUser();
                $id = $table->id;
                $canEdit = $user->authorise('core.edit', 'com_facturacion') || $user->authorise('core.create', 'com_facturacion');
                if (!$canEdit && $user->authorise('core.edit.own', 'com_facturacion')) {
                    $canEdit = $user->id == $table->created_by;
                }

                if (!$canEdit) {
                    JError::raiseError('500', JText::_('JERROR_ALERTNOAUTHOR'));
                }
                
				// Check published state.
				if ($published = $this->getState('filter.published'))
				{
					if ($table->state != $published) {
						return $this->_item;
					}
				}

				// Convert the JTable to a clean JObject.
				$properties = $table->getProperties(1);
				$this->_item = JArrayHelper::toObject($properties, 'JObject');
			} elseif ($error = $table->getError()) {
				$this->setError($error);
			}
		}

		return $this->_item;
	}
    
	public function getTable($type = 'Facturacion', $prefix = 'FacturacionTable', $config = array())
	{   
        $this->addTablePath(JPATH_COMPONENT_ADMINISTRATOR.'/tables');
        return JTable::getInstance($type, $prefix, $config);
	}     

    
	/**
	 * Method to check in an item.
	 *
	 * @param	integer		The id of the row to check out.
	 * @return	boolean		True on success, false on failure.
	 * @since	1.6
	 */
	public function checkin($id = null)
	{
		// Get the id.
		$id = (!empty($id)) ? $id : (int)$this->getState('facturacion.id');

		if ($id) {
            
			// Initialise the table
			$table = $this->getTable();

			// Attempt to check the row in.
            if (method_exists($table, 'checkin')) {
                if (!$table->checkin($id)) {
                    $this->setError($table->getError());
                    return false;
                }
            }
		}

		return true;
	}

	/**
	 * Method to check out an item for editing.
	 *
	 * @param	integer		The id of the row to check out.
	 * @return	boolean		True on success, false on failure.
	 * @since	1.6
	 */
	public function checkout($id = null)
	{
		// Get the user id.
		$id = (!empty($id)) ? $id : (int)$this->getState('facturacion.id');

		if ($id) {
            
			// Initialise the table
			$table = $this->getTable();

			// Get the current user object.
			$user = JFactory::getUser();

			// Attempt to check the row out.
            if (method_exists($table, 'checkout')) {
                if (!$table->checkout($user->get('id'), $id)) {
                    $this->setError($table->getError());
                    return false;
                }
            }
		}

		return true;
	}    
    
	/**
	 * Method to get the profile form.
	 *
	 * The base form is loaded from XML 
     * 
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_facturacion.facturacion', 'facturacionform', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_facturacion.edit.facturacion.data', array());
        if (empty($data)) {
            $data = $this->getData();
        }
        
        return $data;
	}

	/**
	 * Method to save the form data.
	 *
	 * @param	array		The form data.
	 * @return	mixed		The user id on success, false on failure.
	 * @since	1.6
	 */
	public function save($data)
	{
		$id = (!empty($data['id'])) ? $data['id'] : (int)$this->getState('facturacion.id');
        $state = (!empty($data['state'])) ? 1 : 0;
        $user = JFactory::getUser();

        if($id) {
            //Check the user can edit this item
            $authorised = $user->authorise('core.edit', 'com_facturacion') || $authorised = $user->authorise('core.edit.own', 'com_facturacion');
            if($user->authorise('core.edit.state', 'com_facturacion') !== true && $state == 1){ //The user cannot edit the state of the item.
                $data['state'] = 0;
            }
        } else {
            //Check the user can create new items in this section
            $authorised = $user->authorise('core.create', 'com_facturacion');
            if($user->authorise('core.edit.state', 'com_facturacion') !== true && $state == 1){ //The user cannot edit the state of the item.
                $data['state'] = 0;
            }
        }

        if ($authorised !== true) {
            JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
            return false;
        }
        
        $table = $this->getTable();
        if ($table->save($data) === true) {
            return $table->id;
        } else {
            return false;
        }
        
	}
    
     function delete($data)
    {
        $id = (!empty($data['id'])) ? $data['id'] : (int)$this->getState('facturacion.id');
        if(JFactory::getUser()->authorise('core.delete', 'com_facturacion') !== true){
            JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
            return false;
        }
        $table = $this->getTable();
        if ($table->delete($data['id']) === true) {
            return $id;
        } else {
            return false;
        }
        
        return true;
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

	public function bajaComprobante($id_comprobante){ 

	// Get a db connection.
	    $db = JFactory::getDbo();

	// Create a new query object.
	    $query = $db->getQuery(true);

		$query->select('*');
	    $query->from($db->quoteName('#__comprobantes'));
	    $query->where('id_comprobante ='.$id_comprobante . ' AND id_tipo_comp = 2');
	    $db->setQuery($query);
        $db->execute();
        $rows = $db->getNumRows();

        if ($rows == 0) {
		// Select all records from the user profile table where key begins with "custom.".
		// Order it by the ordering field.
	        $query = $db->getQuery(true);
	        $query = "INSERT INTO u5f7a_comprobantes (
					  `id_comprobante`,
					  `id_tipo_comp`,
					  `fecha_emicion`,
					  `id_tipo_pago`,
					  `total`,
					  `fecha_vto`,
					  `id_proveedor`,
					  `id_usuario`,
					  `cliente`,
					  `editar`,
					  `baja`,
					  `cerrar`
					) 
					SELECT 
					  id_comprobante,
					  2,
					  now(),
					  `id_tipo_pago`,
					  `total`,
					  `fecha_vto`,
					  `id_proveedor`,
					  `id_usuario`,
					  `cliente` ,
					  1,
					  0,
					  1
					FROM
					  `facturin`.`u5f7a_comprobantes` 
					WHERE id_comprobante = ".$id_comprobante;

	        $db->setQuery($query);
	        $db->execute();
	        $rows = $db->getAffectedRows();

		    if($rows == 1){
				return true;	    
			}else{
				return false;
			}
		}else {
			return false;
		}

	}      	

	public function pagarComprobante($id_comprobante){ 

	// Get a db connection.
	    $db = JFactory::getDbo();

	// Create a new query object.
	    $query = $db->getQuery(true);

		$fields = array(
		    $db->quoteName('editar') . ' = 0',
		    $db->quoteName('baja') . ' = 0',
		    $db->quoteName('cerrar') . ' = 0'
		);

		$conditions = array(
		    $db->quoteName('id_comprobante') . ' = ' . $id_comprobante, 
		    $db->quoteName('id_tipo_comp') . ' = 1'
		);

		$query->update($db->quoteName('#__comprobantes'));
	    $query->set($fields);
	    $query->where($conditions);
	    $db->setQuery($query);

	    if($db->execute()){
	    	return true;
	    }else{
	    	return false;
	    }



	}      	
}