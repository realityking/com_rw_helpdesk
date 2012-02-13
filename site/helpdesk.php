<?php

defined('_JEXEC') or die;

define('_EASYBOOK_VERSION', '1.1');

// Require the base controller
require_once JPATH_COMPONENT.'/controller.php';

require_once JPATH_COMPONENT.'/helpers/helpdesk.php';
require_once JPATH_COMPONENT.'/helpers/content.php';
require_once JPATH_COMPONENT.'/helpers/smilie.php';

// Require specific controller if requested
if($controller = JRequest::getWord('controller')) {
    $path = JPATH_COMPONENT.'/controllers/'.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}

// Create the controller
$classname    = 'HelpdeskController'.$controller;
$controller   = new $classname();

$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
