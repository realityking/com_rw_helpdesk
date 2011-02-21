<?php

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * Helpdesk Model
 *
 * @package    Helpdesk
 */
class HelpdeskModelHelpdesk extends JModel
{
	/**
	 * Helpdesk entry array
	 *
	 * @var array
	 */
	var $_data;
	
	var $_total;

	var $_pagination;
	
	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	function _buildQuery()
	{
		$app = JFactory::getApplication();
		$ebconfig = &$app->getParams();

		//preventing sql injections
		$start = ( JRequest::getVar( 'limitstart', 0, '', 'int' ) );
		$order = $this->_db->getEscaped($ebconfig->get('entries_order', "DESC"));
		$limit = intval($ebconfig->get('entries_perpage', 5));

		//loading acl stuff
		$user = & JFactory::getUser();
		$canPublish	= $user->authorize('com_helpdesk', 'publish', 'content', 'all');

		//bulding querys
		if ($canPublish) {
			$query = "SELECT * FROM #__helpdesk"
		. "\nORDER BY hdate " . $order
		. "\nLIMIT $start, " .$limit;
		} else {
			$query = "SELECT * FROM #__helpdesk"
		. "\nWHERE published = 1"
		. "\nORDER BY hdate " . $order
		. "\nLIMIT $start, " .$limit;
		}
	
		return $query;
	}
	
	function _buildCountQuery()
	{	
		//preparing ACL stuff
		$user = & JFactory::getUser();
		$canPublish	= $user->authorize('com_helpdesk', 'publish', 'content', 'all');

		//building query
		if ($canPublish){
			$query = "SELECT * FROM #__helpdesk";
		} else {
			$query = "SELECT * FROM #__helpdesk"
		. " WHERE published = 1";
		}

		return $query;
	}
	
	/**
	 * Retrieves the helpdesk entrys
	 * @return array Array of objects containing the data from the database
	 */
	function getData()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_data )) {
			$query = $this->_buildQuery();
			$this->_data = $this->_getList( $query );
		}
		return $this->_data;
	}

	function getPagination()
	{
		$app = JFactory::getApplication();
		$ebconfig = &$app->getParams();
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), JRequest::getVar( 'limitstart', 0 ), $ebconfig->get('entries_perpage', 5) );
		}

		return $this->_pagination;
	}

	/**
	 * Retrieves the count of helpdesk entrys
	 * @return array Array of objects containing the data from the database
	 */
	function getTotal()
	{
		if (empty($this->_total)) {
			$query = $this->_buildCountQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}
}
