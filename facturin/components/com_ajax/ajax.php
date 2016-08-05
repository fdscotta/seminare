<?php
require_once(JPATH_COMPONENT.DS.'controller.php');
//crear controller
$controller= new ajaxController();
//perform del request task
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
?>