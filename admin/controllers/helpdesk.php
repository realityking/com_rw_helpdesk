<?php
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controlleradmin');

/**
 * Helpdesk Component Controller
 *
 * @package    Helpdesk
 */
class HelpdeskControllerHelpdesk extends JControllerAdmin
{
	public function &getModel($name = 'Entry', $prefix = 'HelpdeskModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}
