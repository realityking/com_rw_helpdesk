<?php
// no direct access
defined('_JEXEC') or die;

foreach ($this->entrys as $entry) {
?>
<div class="h_frame 
<?php
	switch($entry->hstatus) {
		// Nicht bearbeitet, ROT
		case '0':
			echo "red";
			break;
		// Wird bearbeitet, GELB
		case '1':
			echo "yellow";
			break;
		// Erledigt, GRÜN
		case '2':
			echo "green";
			break;
	}
?>
">

<div class="h_top 
<?php
	switch($entry->hstatus) {
		case '0':
			echo "red";
			break;
		case '1':
			echo "yellow";
			break;
		case '2':
			echo "green";
			break;
	}
?>
">
<? //print_r($entry); ?>
<div class="h_top_left">
<b class="h_big"><a name="hentry_<?php echo $entry->id; ?>"></a><? 
if ($entry->published) {
	
	if ($entry->hfac<>"" AND $this->params->get('show_fac', true)) echo $entry->hfac.": ";
	if ($entry->hmajor<>"" AND $this->params->get('show_major', true)) echo $entry->hmajor;
}
 ?></b>
</div>
<div class="h_top_right">

<?php
	switch($entry->hstatus) {
		case '-1':
			echo JText::_('COM_HELPDESK_DECLINED');
			break;
		case '0':
			echo JText::_('COM_HELPDESK_NOT_IN_PROGRESS');
			break;
		case '1':
			echo JText::_('COM_HELPDESK_IN_PROGRESS');
			break;
		case '2':
			echo JText::_('COM_HELPDESK_FINISHED');
			break;
	}
?>
</div>
</div>

<div class="h_content">

<?php if ($entry->hfile<>"" AND $this->params->get('show_upload', true)) { ?>
<div class='h_file'>
<?php
//	echo JText::_('Attachment').": "."<a href=\"".$this->params->get('file_dir','')."/".$entry->hfile."\" target=\"_blank\" >".$entry->hfile."</a>";
	echo "<a href=\"".$this->params->get('file_dir','')."/".$entry->hfile."\" target=\"_blank\" ><img src=\"".$this->params->get('file_dir','')."/".$entry->hfile."\" alt=\"".$entry->hfile."\" /></a>";
?>
</div>
<?php } ?>


<?php echo HelpdeskHelperContent::parse($entry->htext) ?>
<div class="h_footer"><b class="h_small"><?php echo $entry->hfname . " " . substr($entry->hname,0,1) . ". | "; ?>
<?php
	echo JHtml::_('date', $entry->hdate, JText::_('DATE_FORMAT_LC2')). "";
	if (!$entry->published) echo " | </b><b class='h_small_red'>". JText::_( 'Entry offline');
?>
</b></div>

</div>

<?php if($entry->hcomment){ ?>
<div class="h_admincomment">
<?php echo JHtml::_('image', JURI::root().'media/com_helpdesk/images/admin.png', JText::_('Admin Comment:'), 'class="h_align_middle" style="padding-bottom: 2px;"'); ?>
<b><?php echo JText::_( 'COM_HELPDESK_ADMIN_COMMENT'); ?>:</b>
<br />
<?php echo HelpdeskHelperContent::parse($entry->hcomment) ?>
</div><?php } ?>

</div>
<?php } ?>
