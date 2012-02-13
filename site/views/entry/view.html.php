<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class HelpdeskViewEntry extends JView
{
	/**
	 * Hellos view display method
	 * @return void
	 **/
	function display($tpl = null) {
		global $Itemid;
		$app	= JFactory::getApplication();
		$doc	= JFactory::getDocument();
		$menus	= &JSite::getMenu();
		$params	= &$app->getParams('com_helpdesk');
		$task	= JRequest::getVar('task');

		// Set CSS File
		JHtml::_('stylesheet', 'helpdesk.css', JURI::root().'/media/com_helpdesk/css/');

		// Get data from the model
		$entry	= & $this->get('Data');

		// Set the document page title
		$menu = $menus->getActive();
		switch($task) {
			case 'add':
				$doc->setTitle($heading = $menu->title." - ".JTEXT::_('Sign Helpdesk'));
				break;
			case 'edit':
				$doc->setTitle($heading = $menu->title." - ".JTEXT::_('Edit Entry'));
				break;
			case 'comment':
				$doc->setTitle($heading = $menu->title." - ".JTEXT::_('Edit Comment'));
				break;
		}

		$heading = $doc->getTitle();

		$this->assignRef('heading',	$heading);
		$this->assignRef('entry',	$entry);
		$this->assignRef('params', 	$params);

		parent::display($tpl);
	}
}
