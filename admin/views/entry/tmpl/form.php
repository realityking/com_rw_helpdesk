<?php
defined('_JEXEC') or die ('Restricted access');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_HELPDESK_DETAILS'); ?></legend>
			<ul class="adminformlist">
			<li>
				<?php echo $this->form->getLabel('hname'); ?>
				<?php echo $this->form->getInput('hname'); ?>
			</li>
			<li>
				<?php echo $this->form->getLabel('hfname'); ?>
				<?php echo $this->form->getInput('hfname'); ?>
			</li>
			<li>
				<?php echo $this->form->getLabel('hfac'); ?>
				<?php echo $this->form->getInput('hfac'); ?>
			</li>
			<li>
				<?php echo $this->form->getLabel('hmajor'); ?>
				<?php echo $this->form->getInput('hmajor'); ?>
			</li>
			<li>
				<label for="hfile"><?php echo JText::_('COM_HELPDESK_ATTACHMENT'); ?></label>
				<?php
			$params = JComponentHelper::getParams( 'com_helpdesk' );
			$upload_location = $params->get('file_dir','');
			if ($this->entry->hfile) {
				echo "<a href=\"../".$upload_location."/".$this->entry->hfile."\" target=\"_blank\">".$this->entry->hfile."</a>";
			} else {
				echo '<input type="text" value="'.JText::_('COM_HELPDESK_NO_FILE').'" readonly="readonly" class="readonly" size="10" />';
			}
		?>
			</li>
			<li>
				<?php echo $this->form->getLabel('hmail'); ?>
				<?php echo $this->form->getInput('hmail'); ?>
			</li>
			<li>
				<?php echo $this->form->getLabel('published'); ?>
				<?php echo $this->form->getInput('published'); ?>
			</li>
			<li>
				<?php echo $this->form->getLabel('hstatus'); ?>
				<?php echo $this->form->getInput('hstatus'); ?>
			</li>
			<li>
				<?php echo $this->form->getLabel('declinemail'); ?>
				<?php echo $this->form->getInput('declinemail'); ?>
			</li>
			<li>
				<?php echo $this->form->getLabel('htext'); ?>
				<?php echo $this->form->getInput('htext'); ?>
			</li>
			<li>
				<?php echo $this->form->getLabel('hcomment'); ?>
				<?php echo $this->form->getInput('hcomment'); ?>
			</li>
			</ul>
		</fieldset>
	</div>

	<div class="width-40 fltrt">
		<?php echo JHtml::_('sliders.start','content-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
			<?php echo JHtml::_('sliders.panel',JText::_('COM_HELPDESK_BASIC_OPTIONS'), 'basic-options'); ?>
			<fieldset class="panelform">
				<li>
					<?php echo $this->form->getLabel('hip'); ?>
					<?php echo $this->form->getInput('hip'); ?>
				</li>
				<li>
					<?php echo $this->form->getLabel('hdate'); ?>
					<?php echo $this->form->getInput('hdate'); ?>
				</li>
			</fieldset>

		<?php echo JHtml::_('sliders.end'); ?>
		<input type="hidden" name="option" value="com_helpdesk" />
		<?php echo $this->form->getInput('id'); ?>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="controller" value="entry" />
		<?php echo JHtml::_( 'form.token' ); ?>
	</div>
</form>