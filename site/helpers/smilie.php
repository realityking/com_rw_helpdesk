<?php

defined('_JEXEC') or die;

class HelpdeskHelperSmilie
{
	public static function getSmilies()
	{
		$smiley[':zzz']   = "sm_sleep.gif";    $smiley[':upset'] = "sm_upset.gif";
		$smiley[';)']     = "sm_wink.gif";     $smiley['8)']     = "sm_cool.gif";
		$smiley[':p']     = "sm_razz.gif";     $smiley[':roll']  = "sm_rolleyes.gif";
		$smiley[':eek']   = "sm_bigeek.gif";   $smiley[':grin']  = "sm_biggrin.gif";
		$smiley[':)']     = "sm_smile.gif";    $smiley[':sigh']  = "sm_sigh.gif";
		$smiley[':?']     = "sm_confused.gif"; $smiley[':cry']   = "sm_cry.gif";
		$smiley[':(']     = "sm_mad.gif";      $smiley[':x']     = "sm_dead.gif";

		return $smiley;
	}
}
