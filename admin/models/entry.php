<?php

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.modeladmin');

/**
 * Helpdesk Model
 *
 * @package    Helpdesk
 */
class HelpdeskModelEntry extends JModelAdmin
{
	var $_data = null;
	var $_id = null;			

	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access    public
	 * @return    void
	 */
	function __construct()
	{
	    parent::__construct();
	
	    $array = JRequest::getVar('cid',  0, '', 'array');
	    $this->setId((int)$array[0]);
	}

	/**
 	* Method to set the entry identifier
 	*
 	* @param    int Entry identifier
 	*
 	* @return    void
 	*/
	public function setId($id)
	{
    	// Set id and wipe data
    	$this->_id        = $id;
    	$this->_data    = null;
	}

	/**
	 * Method to store a record
 	*
 	* @return    boolean    True on success
 	*/
	public function store()
	{    	
    	$row =& $this->getTable();
    	$data = JRequest::get('post');

    	// Bind the form fields to the hello table
    	if (!$row->bind($data['jform'])) {
       	 	$this->setError($this->_db->getErrorMsg());
        	return false;
    	}

		// Make sure the hello record is valid
	    if (!$row->check()) {
	        $this->setError($this->_db->getErrorMsg());
	        return false;
	    }

   		// Store the entry to the database
    	if (!$row->store()) {
        	$this->setError($this->_db->getErrorMsg());
        	return false;
    	}

    	return true;
	}

	// Publishes an entry or unpublishes it
	public function publish($state)
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

	    return parent::publish($cids, $state);
	}

	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_helpdesk.entry', 'entry', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	protected function loadFormData()
	{
		$data = $this->getItem();

		return $data;
	}
}
