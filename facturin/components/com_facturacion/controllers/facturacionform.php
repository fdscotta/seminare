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

require_once JPATH_COMPONENT . '/controller.php';

/**
* Facturacion controller class.
*/
class FacturacionControllerFacturacionForm extends FacturacionController {

/**
* Method to check out an item for editing and redirect to the edit form.
*
* @since	1.6
*/
public function edit() {
    $app = JFactory::getApplication();

// Get the previous edit id (if any) and the current edit id.
    $previousId = (int) $app->getUserState('com_facturacion.edit.facturacion.id');
    $editId = JFactory::getApplication()->input->getInt('id', null, 'array');

// Set the user id for the user to edit in the session.
    $app->setUserState('com_facturacion.edit.facturacion.id', $editId);

// Get the model.
    $model = $this->getModel('FacturacionForm', 'FacturacionModel');

// Check out the item
    if ($editId) {
        $model->checkout($editId);
    }

// Check in the previous user.
    if ($previousId) {
        $model->checkin($previousId);
    }

// Redirect to the edit screen.
    $this->setRedirect(JRoute::_('index.php?option=com_facturacion&view=facturacionform&layout=edit', false));
}

/**
* Method to save a user's profile data.
*
* @return	void
* @since	1.6
*/
public function save() {
// Check for request forgeries.
    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

// Initialise variables.
    $app = JFactory::getApplication();
    $model = $this->getModel('FacturacionForm', 'FacturacionModel');

// Get the user data.
    $data = JFactory::getApplication()->input->get('jform', array(), 'array');

// Validate the posted data.
    $form = $model->getForm();
    if (!$form) {
        JError::raiseError(500, $model->getError());
        return false;
    }

// Validate the posted data.
    $data = $model->validate($form, $data);

// Check for errors.
    if ($data === false) {
// Get the validation messages.
        $errors = $model->getErrors();

// Push up to three validation messages out to the user.
        for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
            if ($errors[$i] instanceof Exception) {
                $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
            } else {
                $app->enqueueMessage($errors[$i], 'warning');
            }
        }

        $input = $app->input;
        $jform = $input->get('jform', array(), 'ARRAY');

// Save the data in the session.
        $app->setUserState('com_facturacion.edit.facturacion.data', $jform, array());

// Redirect back to the edit screen.
        $id = (int) $app->getUserState('com_facturacion.edit.facturacion.id');
        $this->setRedirect(JRoute::_('index.php?option=com_facturacion&view=facturacionform&layout=edit&id=' . $id, false));
        return false;
    }

// Attempt to save the data.
    $return = $model->save($data);

// Check for errors.
    if ($return === false) {
// Save the data in the session.
        $app->setUserState('com_facturacion.edit.facturacion.data', $data);

// Redirect back to the edit screen.
        $id = (int) $app->getUserState('com_facturacion.edit.facturacion.id');
        $this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
        $this->setRedirect(JRoute::_('index.php?option=com_facturacion&view=facturacionform&layout=edit&id=' . $id, false));
        return false;
    }


// Check in the profile.
    if ($return) {
        $model->checkin($return);
    }

// Clear the profile id from the session.
    $app->setUserState('com_facturacion.edit.facturacion.id', null);

// Redirect to the list screen.
    $this->setMessage(JText::_('COM_FACTURACION_ITEM_SAVED_SUCCESSFULLY'));
    $menu = JFactory::getApplication()->getMenu();
    $item = $menu->getActive();
    $url = (empty($item->link) ? 'index.php?option=com_facturacion&view=facturacions' : $item->link);
    $this->setRedirect(JRoute::_($url, false));

// Flush the data from the session.
    $app->setUserState('com_facturacion.edit.facturacion.data', null);
}

function cancel() {

    $app = JFactory::getApplication();

// Get the current edit id.
    $editId = (int) $app->getUserState('com_facturacion.edit.facturacion.id');

// Get the model.
    $model = $this->getModel('FacturacionForm', 'FacturacionModel');

// Check in the item
    if ($editId) {
        $model->checkin($editId);
    }

    $menu = JFactory::getApplication()->getMenu();
    $item = $menu->getActive();
    $url = (empty($item->link) ? 'index.php?option=com_facturacion&view=facturacions' : $item->link);
    $this->setRedirect(JRoute::_($url, false));
}

public function remove() {

// Initialise variables.
    $app = JFactory::getApplication();
    $model = $this->getModel('FacturacionForm', 'FacturacionModel');

// Get the user data.
    $data = array();
    $data['id'] = $app->input->getInt('id');

// Check for errors.
    if (empty($data['id'])) {
// Get the validation messages.
        $errors = $model->getErrors();

// Push up to three validation messages out to the user.
        for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
            if ($errors[$i] instanceof Exception) {
                $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
            } else {
                $app->enqueueMessage($errors[$i], 'warning');
            }
        }

// Save the data in the session.
        $app->setUserState('com_facturacion.edit.facturacion.data', $data);

// Redirect back to the edit screen.
        $id = (int) $app->getUserState('com_facturacion.edit.facturacion.id');
        $this->setRedirect(JRoute::_('index.php?option=com_facturacion&view=facturacion&layout=edit&id=' . $id, false));
        return false;
    }

// Attempt to save the data.
    $return = $model->delete($data);

// Check for errors.
    if ($return === false) {
// Save the data in the session.
        $app->setUserState('com_facturacion.edit.facturacion.data', $data);

// Redirect back to the edit screen.
        $id = (int) $app->getUserState('com_facturacion.edit.facturacion.id');
        $this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
        $this->setRedirect(JRoute::_('index.php?option=com_facturacion&view=facturacion&layout=edit&id=' . $id, false));
        return false;
    }


// Check in the profile.
    if ($return) {
        $model->checkin($return);
    }

// Clear the profile id from the session.
    $app->setUserState('com_facturacion.edit.facturacion.id', null);

// Redirect to the list screen.
    $this->setMessage(JText::_('COM_FACTURACION_ITEM_DELETED_SUCCESSFULLY'));
    $menu = JFactory::getApplication()->getMenu();
    $item = $menu->getActive();
    $url = (empty($item->link) ? 'index.php?option=com_facturacion&view=facturacions' : $item->link);
    $this->setRedirect(JRoute::_($url, false));

// Flush the data from the session.
    $app->setUserState('com_facturacion.edit.facturacion.data', null);
}

//a partir de aqui las funciones ajax
// Busco un articulo
function buscarCodBarra(){

    $codigo_barra = $_REQUEST['query'];
// Get a db connection.
    $db = JFactory::getDbo();

// Create a new query object.
    $query = $db->getQuery(true);

// Select all records from the user profile table where key begins with "custom.".
// Order it by the ordering field.
    $query->select($db->quoteName(array('id','title','extra_fields')));
    $query->from($db->quoteName('#__k2_items'));

// Reset the query using our newly populated query object.
    $db->setQuery($query);

// Load the results as a list of stdClass objects (see later for more options on retrieving data).
    $results = $db->loadRowList();

    if($results){
        foreach ($results as $result) {
// los campos extra los decodifico	
        $JSON =  $result[2];   
        $obj = json_decode($JSON);     

        $pos = strpos(strtoupper($result[1]),strtoupper(trim($codigo_barra)));

        if(trim($obj[0]->value) == trim($codigo_barra)) {
            $array = array(
                'descripcion' => $result[1],
                'val' => $obj[0]->value,
                'precio' => $obj[2]->value
                );
            echo json_encode($array);die;        
        } elseif($pos !== false) {
            $array = array(
                'descripcion' => $result[1],
                'val' => $obj[0]->value,
                'precio' => $obj[2]->value
                );
            echo json_encode($array);die;        
        }

        }
// encontro un articulo
        echo json_encode($array);die; 
    } else {
// no encontro ningun articulo
        echo json_encode("");die;   
    }
}	

function buscarCodLike(){ 

    $codigo_barra = $_REQUEST['query'];

// Get a db connection.
    $db = JFactory::getDbo();

// Create a new query object.
    $query = $db->getQuery(true);

// Select all records from the user profile table where key begins with "custom.".
// Order it by the ordering field.
    $query->select($db->quoteName(array('id','title','extra_fields')));
    $query->from($db->quoteName('#__k2_items'));
    //$query->where($db->quoteName('id') . ' = ' . $codigo_barra . 'OR' . $db->quoteName('title') . ' like %' . $codigo_barra .'%');
    echo "<pre>";print_r($query);echo "</pre>";die;
// Reset the query using our newly populated query object.
    $db->setQuery($query);

// Load the results as a list of stdClass objects (see later for more options on retrieving data).
    $results = $db->loadResult();

    if($results){
        foreach ($results as $result) {
// los campos extra los decodifico  
            $JSON =  $results[2];   

            $obj = json_decode($JSON); 
            echo "<pre>";print_r($obj);echo "</pre>";

            $array = array(
                'descripcion' => $results[1],
                'val' => $obj[0]->value,
                'precio' => $obj[2]->value
                );
// encontro un articulo
            echo json_encode($array);die; 
        }
    } else {
// no encontro ningun articulo
        echo json_encode("");die;   
    }

}   


public function confirmaVenta(){
// los datos de los articulos facturados
//obtengo los datos para facturar
    $venta = $_REQUEST['query'];
    $arrayVenta = explode("//", $venta);
    $listaVenta = array();

    $cliente = $_REQUEST['cliente'];

    date_default_timezone_set('America/Argentina/Buenos_Aires');		
    $dt = new DateTime();
    $fecha = $dt->format('Y-m-d H:i:s');

    $user = JFactory::getUser();
    $id_usuario = $user->id;

// calculo el total
    $total = 0;
    foreach($arrayVenta as $arrayV){
        $lista = explode("@", $arrayV);
        if(!empty($lista[0])){ 
            $total =  $lista[4] + $total;
        }
    }
// *********************************
// inserto en la tabla comprobante 		
// *********************************
// Get a db connection.
    $db = JFactory::getDbo();

// Create a new query object.
    $query = $db->getQuery(true);
    $query = "INSERT INTO u5f7a_comprobantes VALUES ('',1,'".$fecha."',1,$total,'',0,$id_usuario,$cliente,1,1,1)";

    $db->setQuery($query);
    $db->query();
// id del ultimo registro insertado 
    $id_comprobante = $db->insertid(); 

    $i = 0;
    foreach($arrayVenta as $arrayV){
        $lista = explode("@", $arrayV);
    if(!empty($lista[0])){ 
        $listaVenta[$i]['codigo_articulo'] = $lista[0];
        $listaVenta[$i]['descripcion'] = $lista[1];
        $listaVenta[$i]['cantidad'] = $lista[2];
        $listaVenta[$i]['precio'] = $lista[3];
        $listaVenta[$i]['total'] = $lista[4];

// ******************************************
// inserto en la tabla comprobante_detalle		
// ******************************************
// Create a new query object.
        $query = $db->getQuery(true);
        $query = "insert into u5f7a_comprobante_detalle VALUES ('',$id_comprobante,$lista[0],$lista[2],$lista[3],$lista[4])";

        $db->setQuery($query);
        $db->query();

        $i++;
        }
    }
            $array = array(
            'respuesta' => 'todo bien'
            );

    echo json_encode($array);die;
}	

function seleccionArticulo(){
// los datos de los articulos facturados
    $id_art = $_REQUEST['query'];

    echo json_encode($id_art);die;
// }

}	

function bajaComprobante(){

    $model = $this->getModel('FacturacionForm', 'FacturacionModel');
    if($model->bajaComprobante($_REQUEST['id_comp'])){
        // Redirect to the list screen.
        $this->setMessage("El comprobante ".$_REQUEST['id_comp']." se dio de baja");
        $url = 'index.php/buscar-comprobantes?id_emp='.$_REQUEST['id_emp'];
        $this->setRedirect($url);
    }else{
        $this->setMessage("El comprobante ".$_REQUEST['id_comp']." ya esta dado de baja");
        $url = 'index.php/buscar-comprobantes?id_emp='.$_REQUEST['id_emp'];
        $this->setRedirect($url);        
    }

}   

function pagarComprobante(){

    $model = $this->getModel('FacturacionForm', 'FacturacionModel');
    if($model->pagarComprobante($_REQUEST['id_comp'])){
        // Redirect to the list screen.
        $this->setMessage("El pago del comprobante ".$_REQUEST['id_comp']." se completo");
        $url = 'index.php/buscar-comprobantes?id_emp='.$_REQUEST['id_emp'];
        $this->setRedirect($url);        
    }else{
        $this->setMessage("El pago del comprobante ".$_REQUEST['id_comp']."  no se completo", 'warning');
        $url = 'index.php/buscar-comprobantes?id_emp='.$_REQUEST['id_emp'];
        $this->setRedirect($url);        
    }

}   

}
