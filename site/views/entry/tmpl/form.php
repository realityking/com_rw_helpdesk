<?php

defined('_JEXEC') or die;

 # Javascript for SmilieInsert and Form Check
global $Itemid;
//echo $lang."!!! ".$Itemid;
?>
<div class="helpdesk edit">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
	<?php endif; ?>
	<form name="hookForm" id="adminForm" action="<?php JRoute::_('index.php'); ?>" target="_top" method="post" enctype="multipart/form-data">
	<fieldset>
		<a class="view" href="<?php echo JRoute::_('index.php?option=com_helpdesk&view=helpdesk&Itemid='.$Itemid); ?>">
			<strong style="float: right;"><?php echo JText::_( 'Read Helpdesk'); ?>
			<?php echo JHtml::_('image', JURI::root().'media/com_helpdesk/images/book.png', JText::_('Read Helpdesk').":", 'height="16" width="16" class="png" style="vertical-align: middle;"'); ?></strong>
		</a>

		<legend><?php echo JText::_('New Entry'); ?></legend>
			<div class="formelm">
				<label for="hname"><?php echo JTEXT::_('COM_HELPDESK_NAME'); ?><span class="star">&nbsp;*</span></label>
				<input type="text" name="hname" id="hname" style="width:245px;" class="inputbox" value="<?php echo $this->entry->hname; ?>" />
			</div>
			<div class="formelm">
				<label for="hfname"><?php echo JTEXT::_('COM_HELPDESK_FULLNAME'); ?><span class="star">&nbsp;*</span></label>
				<input type="text" name="hfname" id="hfname" style="width:245px;" class="inputbox" value="<?php echo $this->entry->hfname; ?>" />
			</div>
			<?php if($this->params->get('require_mail', true)) { ?>
			<div class="formelm">
				<label for="hmail"><?php echo JTEXT::_('JGLOBAL_EMAIL'); ?><?php if($this->params->get('require_mail', true)){echo '<span class="star">*</span>'; } ?></label>
				<input type="text" name="hmail" id="hmail" style="width:245px;" class="inputbox" value="<?php echo $this->entry->hmail; ?>" />
			</div>
			<?php } ?>
			<?php if($this->params->get('show_fac', true)) { ?>
			<div class="formelm">
				<label for="hfac"><?php echo JTEXT::_('Facility number'); ?></label>
				<input type="text" name="hfac" id="hfac" style="width:245px;" class="inputbox" value="<?php echo $this->entry->hfac; ?>" />
			</div>
			<?php } ?>
			<?php if($this->params->get('show_major', true)) { ?>
			<div class="formelm">
				<label for="hmajor"><?php echo JTEXT::_('COM_HELPDESK_MAJOR'); ?></label>
				<input type="text" name="hmajor" style="width:245px;" class="inputbox" value="<?php echo $this->entry->hmajor; ?>" />
			</div>
			<?php } ?>
			<?php if($this->params->get('show_upload', true)) { ?>
			<div class="formelm">
				<label for="hfile"><?php echo JTEXT::_('COM_HELPDESK_ATTACHMENT'); ?></label>
				<input type="file" class="fileupload" id="hfile" name="hfile" style='width:245px;'>
			</div>
			<?php } ?>
			<div class="formelm-buttons">
				<input type="submit" name="send" value="<?php echo JTEXT::_('JSUBMIT'); ?>" class="button" />
				<input type="reset" value="<?php echo JTEXT::_('Reset form'); ?>" name="reset" class="button" />
			</div>
			
			<?php 
if($this->entry->htext) {
	$editor =& JFactory::getEditor();
	echo $editor->display('htext', $this->entry->htext, '100%', '400', '70', '15');
} else { ?>
			<textarea id="htext" name="htext" class='inputbox' style="width: 100%;" rows="8"></textarea>
<? } ?>
			<input type="hidden" name="option" value="com_helpdesk" />
    		<input type="hidden" name="task" value="save" />
    		<input type="hidden" name="controller" value="entry" />
			<?php if($this->entry->id){ ?>
				<input type="hidden" name="id" value="<?php echo $this->entry->id; ?>" />
			<?php } ?>
	</fieldset>
	</form>
    <center><span class="small">* <?php echo JTEXT::_('Required field'); ?></span></center>
</div>