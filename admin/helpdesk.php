<?php
// no direct access
defined('_JEXEC') or die ('Restricted access');
define('_HELPDESK_VERSION', '1.1');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_helpdesk')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Require the base controller
require_once(JPATH_COMPONENT.'/controller.php');
require_once(JPATH_COMPONENT.'/helpers/helpdesk.php');

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
$controller   = new $classname( );

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();
