<?php

defined('_JEXEC') or die;

jimport( 'joomla.application.component.modellist' );

/**
 * Helpdesk Model
 *
 * @package    Helpdesk
 */
class HelpdeskModelHelpdesk extends JModelList
{
	function __construct()
	{
		parent::__construct();

		$app = JFactory::getApplication();

		$params = $app->getParams();
		$start = JRequest::getVar('limitstart', 0, '', 'int');
		$order = $this->_db->getEscaped($params->get('entries_order', "DESC"));
		$limit = intval($params->get('entries_perpage', 5));

		$this->setState('limit', $limit);
		$this->setState('limitstart', $start);
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
		$db		= JFactory::getDBO();
		$user	= JFactory::getUser();

		//ACL
		$canPublish	= $user->authorize('com_helpdesk', 'publish', 'content', 'all');

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('*');
		if (!$canPublish) {
			$query->where('published = 1');
		}
		// From the hello table
		$query->from('#__helpdesk');
		return $query;
	}
}
