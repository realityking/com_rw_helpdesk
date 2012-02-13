<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class HelpdeskViewEntry extends JView
{
	protected $form;
	protected $item;

	function display($tpl = null)
	{
	    jimport('joomla.html.pane');
	     
	    JHtml::_('stylesheet', 'admin.css', JURI::root().'/media/com_helpdesk/css/');
	     
	    $entry =& $this->get('Item');
	    $this->item = $this->get('Item');
	    $this->form	= $this->get('Form');
	    
	    $isNew	= ($entry->id < 1);
	
	    JToolBarHelper::title(JText::_('COM_HELPDESK_MANAGER_ENTRY'), 'helpdesk' );
	    JToolBarHelper::save('entry.save');
	    if (empty($this->item->id)) {
			JToolBarHelper::cancel('entry.cancel', 'JTOOLBAR_CANCEL');
		} else {
			JToolBarHelper::cancel('entry.cancel', 'JTOOLBAR_CLOSE');
		}
		
		$config =& JFactory::getConfig();
		$offset = $config->getValue('config.offset');
		
		$date =& JFactory::getDate($entry->hdate);
		$date->setOffset($offset);
		$entry->hdate = $date->toFormat();
		
	    $this->assignRef('entry', $entry);
	    parent::display($tpl);
	}

}