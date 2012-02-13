<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Helpdesk Model
 *
 * @package    Helpdesk
 */
class HelpdeskModelEntry extends JModelAdmin
{
	public function getForm($data = array(), $loadData = true)
	{
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
