<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class HelpdeskHelperRoute
{
	public static function getHelpdeskRoute($id)
	{
		//Create the link
		$link = 'index.php?option=com_helpdesk&view=helpdesk';
		$link .= '&Itemid=' . HelpdeskHelperRoute::_findItem();
		$link .= '#gbentry_'.$id;
		
		return $link;		
	}

	private static function _findItem()
	{
		$component =& JComponentHelper::getComponent('com_helpdesk');

		$menus	= &JApplication::getMenu('site', array());
		$items	= $menus->getItems('componentid', $component->id);
		$match = null;

		foreach($items as $item) {
			if ((@$item->query['view'] == 'helpdesk')) {
				$match = $item->id;
				break;
			}
		}
		
		return $match;
	}
}
