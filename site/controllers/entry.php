<?php

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );


/**
 * Helpdesk Component Controller
 *
 * @package    Helpdesk
 */
class HelpdeskControllerEntry extends JController
{

	var $_access = null;

	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
	}

	function _add_edit()
	{
		JRequest::setVar( 'view', 'entry' );
		JRequest::setVar( 'layout', 'form' );
		parent::display();
	}

	function add()
	{
		$this->_add_edit();
	}

	function edit()
	{
		$this->_add_edit();
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		global $mainframe;
		$app	=  JFactory::getApplication();
 		$uri	=  JFactory::getURI();
		$mail	=& JFactory::getMailer();
		$db		=& JFactory::getDBO();
		$params	=& $app->getParams();			
		
		//ACL stuff
		$canDo	= HelpdeskHelper::getActions();
		$canAdd	= $canDo->get('core.create');
		$canEdit= $canDo->get('core.edit');
		
		//get mail addresses of all super administrators
		//TODO16 This doesn't work anymore in Joomla 1.6
		$query = 'SELECT email' .
				' FROM #__users' .
				' WHERE LOWER( usertype ) = "super administrator" AND sendEmail = 1';
		$db->setQuery( $query );
		$admins = $db->loadResultArray();
		
		//get entry id from request
		$temp = JRequest::get( 'post' );
		$id = $temp['id'];
		$name = $temp['hname'];
		$text = $temp['htext'];

		$filename = $_FILES["hfile"]["name"];
		$filename = str_replace(" ", "_",$filename);
		$filetype = $_FILES["hfile"]["type"];
		$filesize = $_FILES["hfile"]["size"];
		$tmpname  = $_FILES['hfile']['tmp_name'];
		//$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);
		//$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$ext = ".".pathinfo($filename, PATHINFO_EXTENSION);
		//$ext =  $info['extenstion'];
//$msg .= "!!! ".$ext."  ";
		$upload_location = $params->get('file_dir','./uploads');
		if ( substr( $upload_location , strlen($upload_location) - 1) != "/" ) {
			$upload_location .= "/";
		}

		$upload_filetypes = $params->get('file_type','');
		$upload_maxsize = $params->get('file_size', '10000000');

		if ((!$id && $canAdd) || ($id && $canEdit)) {
			$model = $this->getModel( 'entry' );
	
			if ($model->store()) {
				//Set redirection options
				if ($params->get('default_published', true)) {
					$msg .= JText::_( 'Entry Saved' );
					$type = 'message';
				} else {
					$msg .= JText::_( 'Entry saved but has to be approved');
					$type = 'notice';
				}
				$link = JRoute::_( 'index.php?option=com_helpdesk&view=helpdesk', false );

				if ((strlen($filename) > 0)) {
		
					if(!in_array(strtolower($ext),explode(',',strtolower($upload_filetypes))))	 {
						$filetypeok = false;
					} else {
						$filetypeok = true;
					}
					
					if ($upload_filetypes == "*") {
						$filetypeok = true;
					}
				if (($filetypeok > 0) && ($filesize < $upload_maxsize)) {
	
					if (file_exists($upload_location . $filename)) {
		
						$unique_suffix = 1;
						$base = explode($ext,$filename);
						$upload_base = str_replace(" ", "_", $base[0]);
						$new_filename = $upload_location . $filename;
				
						while (file_exists($new_filename)) {
							$upload_base = $upload_base . "_" . $unique_suffix++;
							$new_filename = $upload_location . $upload_base  . $ext;
						}

						$new_filename = $upload_base  . $ext;

						rename($upload_location . $filename, $upload_location . $new_filename);

						$query = "UPDATE #__helpdesk SET hfile='" . $new_filename . "' WHERE id = LAST_INSERT_ID()";
	
						$db->setQuery($query);
						$db->query();

						$upload_fileexist = "no";
					} else {
						$upload_fileexist = "no";
					}
		
					if ( $upload_fileexist == "no" ) {			
						move_uploaded_file($tmpname, $upload_location . $filename);
						$query = "UPDATE #__helpdesk SET hfile='" . $filename . "' WHERE id = LAST_INSERT_ID()";
							
						$db->setQuery($query);
						$db->query();		
					}
				} else {
					$msg .= "<br />" . JText::sprintf('Error with upload', $ext) . "<br />" . JText::_('Allowed types') . ": " . $upload_filetypes . "<br />" . JText::_('File max size') . " (kb): " . ($upload_maxsize / 1024)."<br />";
					$link = JRoute::_( 'index.php?option=com_helpdesk&controller=entry&task=add&retry=true', false );
					$type = 'notice';
					$ferror = true;
				}
				}

				//Send information-mail to administrators
				if ( (!$id AND $params->get('send_mail', true)) && (!$ferror) ) {
					$mail->setSubject( JTEXT::_( 'New Helpdesk entry' ) );
					$mail->setBody( JTEXT::sprintf( 'A new helpdeskentry has been written', $uri->base(), $name, $text ) );
					$mail->addBCC( $admins );
					$mail->Send();
				}
			} else {
				if($filename){
					if(!in_array(strtolower($ext),explode(',',strtolower($upload_filetypes)))){
						$filetypeok = false;
					} else {
						$filetypeok = true;
					}
								
					if ($upload_filetypes == "*") {
						$filetypeok = true;
					}
						
					if (($filetypeok > 0) && ($filesize < $upload_maxsize)){
				
					} else {
						$msg .= JText::sprintf('Error with upload', $ext) . "<br />" . JText::_('Allowed types') . ": " . $upload_filetypes . "<br />" . JText::_('File max size') . " (kb): " . ($upload_maxsize / 1024)."<br />";				
					}
				}

				$msg .= JText::_( 'Error: Please validate your inputs' );
				$link = JRoute::_( 'index.php?option=com_helpdesk&controller=entry&task=add&retry=true', false );
				$type = 'notice';
			}
			$this->setRedirect( $link, $msg, $type );
		} else {
			JError::raiseError( 403, JText::_( 'ALERTNOTAUTH' ) );
		}
	}

	/**
	 * comment record
	 * @return void
	 */
	function comment()
	{
		// Prepare comment form
		JRequest::setVar( 'view', 'entry' );
		JRequest::setVar( 'layout', 'commentform' );
		JRequest::setVar( 'hidemainmenu', 1 );
		parent::display();
	}

	/**
	 * remove record
	 * @return void
	 */
	function remove()
	{
		//Load model and delete entry - redirect afterwards
		$model = $this->getModel( 'entry' );
		if(!$model->delete()) {
			$msg = JText::_( 'Error: Entry could not be deleted' );
			$type = 'error';
		} else {
			$msg = JText::_( 'Entry Deleted' );
			$type = 'message';
		}
		$this->setRedirect( JRoute::_( 'index.php?option=com_helpdesk', false ), $msg, $type );
	}

	function publish() {
		$model = $this->getModel( 'entry' );
		switch($model->publish()) {
			case -1: $msg = JText::_( 'Error: Could not change publish status' );
					 $type = 'error';
					 break;
			case 0: $msg = JText::_( 'Entry unpublished' );
					$type = 'message';
					break;
			case 1: $msg = JText::_( 'Entry published' );
					$type = 'message';
					break;
		}
		$this->setRedirect( JRoute::_( 'index.php?option=com_helpdesk', false ), $msg, $type );
	}
 
	/**
	 * save a comment
         * @return void
	*/
	function savecomment() {
		$model = $this->getModel( 'entry' );
		if(!$model->savecomment()) {
		      $msg = JText::_( 'Error: Could not save comment' );
		      $type = 'error';
		} else {
		      $msg = JText::_( 'Comment saved' );
		      $type = 'message';
		}
		$this->setRedirect( JRoute::_( 'index.php?option=com_helpdesk', false ), $msg, $type );
	}
}
?>
