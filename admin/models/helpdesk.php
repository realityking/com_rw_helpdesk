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
	var $_entry;
	
	var $_total;

	var $_pagination;
	
	var $_version;
	
	function __construct()
	{
		parent::__construct();

		$app = JFactory::getApplication();

		$config = JFactory::getConfig();

		// Get the pagination request variables
		$limit		= $app->getUserStateFromRequest( 'global.list.limit', 'limit', $app->getCfg('list_limit'), 'int' );
		$limitstart	= $app->getUserStateFromRequest( 'helpdesk.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);		
	}
	
	/**
	 * Returns the query
	 * @return string The query to be used to retrieve the rows from the database
	 */
	private function _buildQuery()
	{
		$query = "SELECT * FROM #__helpdesk"
	. " ORDER BY hdate DESC";

		return $query;
	}
	
	/**
	 * Retrieves the helpdesk entrys
	 *
	 * @return array Array of objects containing the data from the database
	 */
	public function getData()
	{
		// Lets load the data if it doesn't already exist
		if (empty( $this->_data )) {
			$query = $this->_buildQuery();
			$this->_data = $this->_getList( $query, $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_data;
	}

	public function getPagination()
	{
		if (empty($this->_pagination)) 	{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}
	/**
	 * Retrieves the count of helpdesk entrys
	 *
	 * @return array Array of objects containing the data from the database
	 */
	public function getTotal()
	{
		if (empty($this->_total)) {
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}
}
