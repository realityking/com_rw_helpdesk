<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.view');

class HelpdeskViewHelpdesk extends JView
{
	function display($tpl = null)
	{
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();

		$doc->link = JRoute::_('index.php?option=com_helpdesk&view=helpdesk');

		JRequest::setVar('limit', $app->getCfg('feed_limit'));

		// Get some data from the model
		$items	=& $this->get( 'Data' );

		foreach ( $items as $item ) {
			// strip html from feed item title
			$title = $this->escape( $item->hname );
			$title = html_entity_decode( $title );

			// url link to article
			$link = JRoute::_('index.php?option=com_helpdesk&view=helpdesk#hentry_'.$item->id);

			// strip html from feed item description text
			$description = $item->htext;
			$date = ( $item->hdate ? date( 'r', strtotime($item->hdate) ) : '' );

			// load individual item creator class
			$feeditem = new JFeedItem();
			$feeditem->title 		= $title;
			$feeditem->link 		= $link;
			$feeditem->description 	= $description;
			$feeditem->date			= $date;
			$feeditem->category   	= 'Helpdesk';

			// loads item info into rss array
			$doc->addItem( $feeditem );
		}
	}
}
