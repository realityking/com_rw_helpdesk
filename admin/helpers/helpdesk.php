<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class HelpdeskHelper {
	/**
	 * Get the actions
	 */
	public static function getActions() {
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_helpdesk';
 
		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.edit.own', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}
