<?php

defined('_JEXEC') or die;

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
		$this->view_list = 'helpdesk';

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

		$this->setRedirect( 'index.php?option=com_helpdesk', $msg, $type);
	}
}
