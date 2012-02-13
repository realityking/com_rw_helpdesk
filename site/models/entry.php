<?php

defined('_JEXEC') or die;

jimport( 'joomla.application.component.model' );

/**
 * Helpdesk Model
 *
 * @package    Helpdesk
 */
class HelpdeskModelEntry extends JModel
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

    	$id = JRequest::getVar('cid',  0, '', 'int');
    	$this->setId($id);
	}

	/**
 	* Method to set the entry identifier
 	*
 	* @access    public
 	* @param    int Entry identifier
 	* @return    void
 	*/
	function setId($id)
	{
    	// Set id and wipe data
    	$this->_id        = $id;
    	$this->_data    = null;
	}

	/**
 	* Method to get a entry
 	* @return object with data
 	*/
	function getData()
	{
    	$app = JFactory::getApplication();
    	$user =& JFactory::getUser();

    	if (	JRequest::getVar('retry') == 'true' ) {
    		$this->_data = $this->getTable();
    		$this->_data->bind($app->getUserState('eb_validation_data'));
    	}

    	// Load the data
    	if (empty( $this->_data )) {
       	 $query = ' SELECT * FROM #__helpdesk '.
       	         '  WHERE id = '.$this->_id;
       	 $this->_db->setQuery( $query );
       	 $this->_data = $this->_db->loadObject();
    	}
    	// When not editing an entry, create a new one
    	if (!$this->_data) {
    	    $this->_data = $this->getTable();
    	    $this->_data->id = 0;
    	    //Insert name and email of the registred user
    	    if ($user->get('id')) {
	    	    $this->_data->hname = $user->get('name');;
	    	    $this->_data->hmail = $user->get('email');;
    	    }
    	}    	    
    	return $this->_data;
	}

	/**
	 * Method to store a record
 	*
 	* @access    public
 	* @return    boolean    True on success
 	*/
	function store()
	{
    	$app = JFactory::getApplication();
    	jimport('joomla.utilities.date');

    	$row =& $this->getTable();
		$params = &$app->getParams();
    	$data = JRequest::get( 'post' );

		$date =& JFactory::getDate();

		// Set Default Values
		if (!$data['id']) {
			$data['hdate'] = $date->toMysql();
			$data['published'] = $params->get('default_published', 1);
			if ($params->get('enable_log', true)) {
				$data['hip'] = getenv('REMOTE_ADDR');
			} else {
				$data['hip'] = "0.0.0.0";
			}
			$data['hcomment'] = null;
		}

		// Make sure the record is valid
	    if (!$this->validate($data)) {
   		     return false;
    	}

    	// Bind the form fields to the table
    	if (!$row->bind($data)) {
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

	function delete()
	{
    	$row =& $this->getTable();

       	if (!$row->delete( $this->_id )) {
           	$this->setError( $this->_db->getErrorMsg() );
           	return false;
       	}
    	return true;
	}

	// Publishes an entry or unpublishes it
	function publish()
	{
		$data = $this->getData();
		$status = $data->published;

		$query = 'UPDATE #__helpdesk SET `published` = '.(int)!$status.' WHERE `id` = '.$this->_id.' LIMIT 1;';
		$this->_db->SetQuery($query);
		if(!$this->_db->query()) {
			$this->setError($this->_db->getErrorMsg());
			return -1;
		}
		return (int)!$status;
	}

	function validate(&$data)
	{
    	$app = JFactory::getApplication();
    	$params = &$app->getParams('com_helpdesk');
    	$user = &JFactory::getUser();
    	$errors = array();

		$filename = $_FILES["hfile"]["name"];
		$filename = str_replace(" ", "_",$filename);
		$filetype = $_FILES["hfile"]["type"];
		$filesize = $_FILES["hfile"]["size"];
		$tmpname  = $_FILES['hfile']['tmp_name'];
		$ext = ".".pathinfo($filename, PATHINFO_EXTENSION);
		$upload_location = $params->get('file_dir','./uploads');

		if ( substr( $upload_location , strlen($upload_location) - 1) != "/" ) {
			$upload_location .= "/";
		}

		$upload_filetypes = $params->get('file_type','');
		$upload_maxsize = $params->get('file_size', '10240000');

		if ($filename) {
			if (!in_array(strtolower($ext),explode(',',strtolower($upload_filetypes)))) {
				$filetypeok = false;
			} else {
				$filetypeok = true;
			}
						
			if ($upload_filetypes == "*") {
				$filetypeok = true;
			}
				
			if (($filetypeok > 0) && ($filesize < $upload_maxsize)) {
		
			} else {
				$error = true;
				$errors['file'] = true;
			}
		}		

		//Name can not be empty
		if (empty($data['hname'])) {
			$error = true;
			$errors['name'] = true;
		}
		
		//Text can not be empty
		if (empty($data['htext'])) {
			$error = true;
			$errors['text'] = true; 
		}
		
		//valid email-address supplied?
		if (!JMailHelper::isEmailAddress($data['hmail']) AND $params->get('require_mail', true)) {
			$error = true;
			$errors['mail'] = true; 
		}

		if ($error) {
			$app->setUserState('eb_validation_errors', $errors);
			$app->setUserState('eb_validation_data' , $data);
			return false;
		} else {
			return true;
		}
    }

	function savecomment()
	{
		$row =& $this->getTable();
    	$data = JRequest::get('post');
	    
	    // Bind the form fields to the table
    	if (!$row->bind($data)) {
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
}
