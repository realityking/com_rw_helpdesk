<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableEntry extends JTable
{
    /**
     * Primary Key
     *
     * @var int
     */
    var $id = null;
    var $hip = null;
    var $hname = null;
    var $hfname = null;
    var $hmail = null;
    var $htext = null;
    var $hdate = null;
    var $hcomment = null;
	var $published = null;
	var $decline = null;
    var $hfac = null;
	var $hmajor = null;
	var $hfile = null;
	var $htype = null;
	var $hsize = null;
	var $hstatus = null;

    /**
     * Constructor
     *
     * @param object Database connector object
     */
	function __construct(&$db)
	{
		parent::__construct('#__helpdesk', 'id', $db);
	}

    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function TableEntry( &$db ) {
        parent::__construct('#__helpdesk', 'id', $db);
    }
}
?>