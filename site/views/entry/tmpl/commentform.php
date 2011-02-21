<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div id="helpdesk">
<h2 class="componentheading"><?php echo $this->heading ?></h2>
<a class="view" href="<?php echo JRoute::_('index.php?option=com_helpdesk&view=helpdesk'); ?>">
<strong><?php echo JText::_( 'Read Helpdesk'); ?>
<?php echo JHTML::_('image', JURI::root().'/media/com_helpdesk/images/book.png', JText::_('Read Helpdesk').":", 'height="16" width="16" style="vertical-align: middle;"'); ?></strong></a>
<br />
<br />
<script type="text/javascript">
 	function h_smilie(thesmile) {
	    document.hookForm.hcomment.value += " "+thesmile+" ";
	    document.hookForm.hcomment.focus();
  	}
</script>
<form name="hookForm" action="<?php JRoute::_('index.php'); ?>" target="_top" method="post">
	<input type="hidden" name="option" value="com_helpdesk" />
	<input type="hidden" name="task" value="savecomment" />
	<input type="hidden" name="controller" value="entry" />
	<input type="hidden" name="id" value="<?php echo $this->entry->id; ?>" />

	<table align="center" width="90%" cellpadding="0" cellspacing="4">
   		<tr>
   			<td width="130" valign="top"><?php echo JTEXT::_('ADMIN COMMENT'); ?>
   			<br />
   			<br />
   			<?php
 			 # Switch for Smilie Support
   			 if ($this->params->get('support_smilie', true)) {
    			  $count=1;
    			  $smiley = HelpdeskHelperSmilie::getSmilies();
			      foreach ($smiley as $i=>$sm) {
			        echo "<a href=\"javascript:h_smilie('$i')\" title='$i'>". JHTML::_('image', JPATH_ROOT.'/media/com_helpdesk/images/smilies/'.$sm, $sm )."</a> ";
			        if ($count%4==0) echo "<br />";
			        $count++;
			      }
			    }
			  ?>
   		 	</td>
    		<td valign="top"><textarea style="width:245px;" rows="8" cols="50" name="hcomment" class="inputbox"><?php echo $this->entry->hcomment; ?></textarea></td>
    	</tr>
		<tr>
    		<td width="130"><input type="submit" name="send" value="<?php echo JTEXT::_('JSUBMIT'); ?>" class="button" /></td>
    		<td align="right"><input type="reset" value="<?php echo JTEXT::_('Reset form'); ?>" name="reset" class="button" /></td>
    	</tr>
	</table>
</form>
</div>
