<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Component Helper
jimport('joomla.application.component.helper');

class HelpdeskHelperContent
{
	public static function parse($message)
	{
		$app = JFactory::getApplication();
		$ebconfig = &$app->getParams();
		# Convert CR and LF to HTML BR command
		$message = preg_replace("/(\015\012)|(\015)|(\012)/","<br />", $message);

		return $message;
	}
}
