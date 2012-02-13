<?php

defined('_JEXEC') or die;

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
