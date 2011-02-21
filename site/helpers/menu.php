<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Component Helper
jimport('joomla.application.component.helper');

class HelpdeskHelperMenu
{
	public static function getName()
	{
		$component =& JComponentHelper::getComponent('com_helpdesk');

		$menus	= &JApplication::getMenu('site', array());
		$items	= $menus->getItems('componentid', $component->id);
		$match = null;

		foreach($items as $item) {
			if ((@$item->query['view'] == 'helpdesk')) {
				$match = $item->name;
				break;
			}
		}

		return $match;		
	}
}
