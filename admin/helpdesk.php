<?php

defined('_JEXEC') or die;
define('_HELPDESK_VERSION', '1.1');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_helpdesk')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

jimport('joomla.application.component.controller');

require_once(JPATH_COMPONENT.'/helpers/helpdesk.php');

$controller	= JController::getInstance('Helpdesk');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
