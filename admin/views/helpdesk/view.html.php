<?php

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * Helpdesk View
 *
 * @package    Helpdesk
 */
class HelpdeskViewHelpdesk extends JView
{
	/**
	 * Helpdesk view display method
	 * @return void
	 **/
	function display($tpl = null)
    {               
        $canDo = HelpdeskHelper::getActions();

		JToolBarHelper::title(JText::_('COM_HELPDESK_MANAGER_HELPDESK'), 'helpdesk' );
		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
		}
		if ($canDo->get('core.delete')) {
			JToolBarHelper::deleteList();
		}
		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList();
		}
		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew();
		}
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_helpdesk', '500');
		}
		JHtml::_('stylesheet', 'admin.css', JURI::root().'/media/com_helpdesk/css/');

        // Get data from the model
		$items		= $this->get('Items');
		$pagination	= $this->get('Pagination');
		
		$this->assignRef('pagination' , $pagination);
        $this->assignRef('items', $items);

        parent::display($tpl);
    }
}
