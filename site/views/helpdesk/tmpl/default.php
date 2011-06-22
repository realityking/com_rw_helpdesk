<?php // no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div id="helpdesk">
<h2 class="componentheading"><?php echo $this->heading ?></h2>
<div style='padding-top: 10px;'>
<?php
if ($this->access->canAdd) {
	echo '<a class="sign" href="'.JRoute::_('index.php?option=com_helpdesk&controller=entry&task=add').'">';
	echo JText::_( 'Sign Helpdesk');
	echo JHtml::_('image', JURI::root().'/media/com_helpdesk/images/new.png', JText::_('Sign Helpdesk').":", 'height="16" width="16" style="vertical-align: middle;"').'</a>';
}
?>
<?php if ($this->params->get('show_introtext')) { ?>
	<div class='h_intro'>
		<?php echo $this->params->get('introtext'); ?>
	</div>
<?php }

//Load Entrys
echo $this->loadTemplate('entrys');
?>
<div>
<span class='h_pagination'><?php echo $this->count ?><br/>
<?php
if ($this->count == 1) {
	echo JText::_('Entry in the Helpdesk');
} else {
	echo JText::_('Entrys in the Helpdesk');
}
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