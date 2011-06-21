<?php
// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controllerform');

/**
 * Helpdesk Component Controller
 *
 * @package    Helpdesk
 */
class HelpdeskControllerEntry extends JControllerForm
{

	var $_access = null;

	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
    	parent::__construct();

    	// Register Extra tasks
    	$this->registerTask('add', 'edit');
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app		= JFactory::getApplication();
		$lang		= JFactory::getLanguage();
		$model		= $this->getModel();
		$table		= $model->getTable();

 		$uri  = JFactory::getURI();
		$mail = JFactory::getMailer();
		$db   = JFactory::getDBO();
		
		$data = JRequest::get('post');

		$decline		= $data['jform']['hstatus'];
		$name			= $data['jform']['hname'];
		$comment		= $data['jform']['hcomment'];
		$usermail		= $data['jform']['hmail'];
		$decline_mail	= $data['jform']['declinemail'];

		//ACL stuff
		$canDo		= HelpdeskHelper::getActions();
		$canAdd 	= $canDo->get('core.create');
		$canEdit	= $canDo->get('core.edit');

		//get mail addresses of all super administrators
		$query = 'SELECT email' .
				' FROM #__users' .
				' WHERE LOWER( usertype ) = "super administrator" AND sendEmail = 1';
		$db->setQuery( $query );
		$admins = $db->loadResultArray();

		$msg = '';
		if ($model->save($data['jform'])) {
        	$msg .= JText::_( 'Entry Saved' );
  			$type = 'message';

  			if (($decline == -1) && ($decline_mail==1)) {
				$body = JText::_('COM_HELPDESK_ENTRY_DECLINED_MAIL_BODY'). $comment;
				$mail->IsHTML(true);
				$mail->setSubject(JText::_('COM_HELPDESK_ENTRY_DECLINED_MAIL_SUBJECT'));
				$mail->setBody( $body );
				$mail->addRecipient( $usermail );
				$mail->addBCC( $admins );
				$mail->Send();
				$msg .= ".  ".JText::_('COM_HELPDESK_DECLINE_MAIL_SENT');
  				$type = 'message';
			}
	    } else {
	        $msg = JText::_('COM_HELPDESK_ERROR_SAVING_ENTRY');
	        $type = 'error';
	    }

		$this->setRedirect( 'index.php?option=com_helpdesk', $msg, $type );
	}

	/**
	 * remove record
	 * @return void
	 */
	function remove()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('JINVALID_TOKEN');

		// Get items to remove from the request.
		$cid = JRequest::getVar('cid', array(), '', 'array');

		if (!is_array($cid) || count($cid) < 1) {
			JError::raiseWarning(500, JText::_($this->text_prefix.'_NO_ITEM_SELECTED'));
		} else {
			// Get the model.
			$model = $this->getModel();

			// Make sure the item ids are integers
			jimport('joomla.utilities.arrayhelper');
			JArrayHelper::toInteger($cid);

			// Remove the items.
			if ($model->delete($cid)) {
				$this->setMessage(JText::plural($this->text_prefix.'_N_ITEMS_DELETED', count($cid)));
				$type = 'message';
			} else {
				$this->setMessage($model->getError());
				$type = 'error';
			}
		}
		$this->setRedirect( JRoute::_( 'index.php?option=com_helpdesk', false ), $msg, $type );
	}

	function publish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('JINVALID_TOKEN');

		$model = $this->getModel( 'entry' );
		if ($model->publish(1)) {
			$msg = JText::_('COM_HELPDESK_ENTRY_PUBLISHED');
			$type = 'message';
		} else {
			$msg = JText::_('COM_HELPDESK_ERROR_ENTRY_CHANGE_PUBLISH_STATUS')." - " .$model->getError();
			$type = 'error';
		}
		$this->setRedirect( JRoute::_('index.php?option=com_helpdesk', false), $msg, $type );
	}

 	function unpublish()
 	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('JINVALID_TOKEN');

		$model = $this->getModel('entry');
		if ($model->publish(0)) {
			$msg = JText::_('COM_HELPDESK_ENTRY_UNPUBLISHED');
			$type = 'message';
		} else {
			$msg = JText::_('COM_HELPDESK_ERROR_ENTRY_CHANGE_PUBLISH_STATUS')." - " .$model->getError();
			$type = 'error';
		}
		$this->setRedirect( JRoute::_('index.php?option=com_helpdesk', false), $msg, $type );
	}
}
