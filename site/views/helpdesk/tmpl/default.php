<?php // no direct access
defined('_JEXEC') or die('Restricted access');
//Load Header
echo $this->loadTemplate('header');
//Load Entrys
echo $this->loadTemplate('entrys');
?>
<div>
<span class='h_pagination'><?php echo $this->count ?><br/>
<?php
if ($this->count == 1) {echo JText::_('Entry in the Helpdesk');} else {
	echo JText::_('Entrys in the Helpdesk');}
?></span>
</div>
<?php
//Load Pagenavigation
if($this->pagination->total > $this->pagination->limit) {
	echo $this->pagination->getPagesLinks();
}
?>
</div>
</div>