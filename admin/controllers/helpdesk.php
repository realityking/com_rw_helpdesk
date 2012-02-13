<?php

defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Helpdesk Component Controller
 *
 * @package    Helpdesk
 */
class HelpdeskControllerHelpdesk extends JControllerAdmin
{
	/**
	 * @return void
	 */
	function __construct()
	{
		$this->view_list = 'helpdesk';

		parent::__construct();
	}

	public function &getModel($name = 'Entry', $prefix = 'HelpdeskModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}
