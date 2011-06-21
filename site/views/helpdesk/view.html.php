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
		$app	= JFactory::getApplication();
		$doc	= JFactory::getDocument();
		$menus	= &JSite::getMenu();
		$params = &$app->getParams('com_helpdesk');
		
		// Set CSS File
		JHtml::_('stylesheet', 'helpdesk.css', JURI::root().'/media/com_helpdesk/css/');
		
		// Get some Data
		$entrys		= $this->get('Items');
		$count		= $this->get('Total');
		$pagination	= $this->get('Pagination');
		
		// Show RSS Feed
		$link		= '&format=feed&limitstart=';
		$attribs	= array('type' => 'application/rss+xml', 'title' => 'RSS 2.0');
		$doc->addHeadLink(JRoute::_($link.'&type=rss'), 'alternate', 'rel', $attribs);
		$attribs	= array('type' => 'application/atom+xml', 'title' => 'Atom 1.0');
		$doc->addHeadLink(JRoute::_($link.'&type=atom'), 'alternate', 'rel', $attribs);
		
		// Prepare ACL checks
		$canDo = HelpdeskHelper::getActions();
		$access = new stdClass();
	
		$access->canAdd			= $canDo->get('core.create');
	
		$access->canPublishOwn	= $canDo->get('core.edit.state');
		$access->canRemoveOwn	= $canDo->get('core.edit.own');
		$access->canEditOwn		= $canDo->get('core.edit.own');
	
		$access->canPublish		= $canDo->get('core.edit.state');
		$access->canRemove		= $canDo->get('core.delete');
		$access->canEdit		= $canDo->get('core.edit');
		$access->canComment		= $canDo->get('core.edit');

		// Assign Data to template
		$this->assignRef( 'heading', $doc->getTitle() );
		$this->assignRef( 'entrys',	$entrys );
		$this->assignRef( 'count', $count);
		$this->assignRef( 'pagination', $pagination);
		$this->assignRef( 'params', $params);
		$this->assignRef( 'access', $access);
		
		// Add HTML Head Link
		$paginationdata = $pagination->getData();
		if ($paginationdata->start->link) {
			$doc->addHeadLink($paginationdata->start->link, "first");
		}
		if ($paginationdata->previous->link) {
			$doc->addHeadLink($paginationdata->previous->link, "prev");
		}
		if ($paginationdata->next->link) {
			$doc->addHeadLink($paginationdata->next->link, "next");
		}
		if ($paginationdata->end->link) {
			$doc->addHeadLink($paginationdata->end->link, "last");
		}

		// Display template
		parent::display($tpl);
	}
}
