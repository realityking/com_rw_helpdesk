<?php
defined('_JEXEC') or die ('Restricted access');

JHtml::_('behavior.multiselect');

$user = JFactory::getUser();
?>
<form action="<?php echo JRoute::_('index.php?option=com_helpdesk&view=helpdesk'); ?>" method="post" name="adminForm" id="adminForm">
<table class="adminlist">
    <thead>
        <tr>
            <th width="20">
				<input type="checkbox" name="toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this);" />
			</th>
			<th width="40">
                <?php echo JText::_('COM_HELPDESK_AUTHOR'); ?>
            </th>
            <th>
                <?php echo JText::_('COM_HELPDESK_MESSAGE'); ?>
            </th>
            <th>
                <?php echo JText::_('COM_HELPDESK_STATUS'); ?>
            </th>
            <th>
                <?php echo JText::_('JPUBLISHED'); ?>
            </th>
            <th>
                <?php echo JText::_('COM_HELPDESK_DATE'); ?>
            </th>
            <th>
                <?php echo JText::_('COM_HELPDESK_COMMENT'); ?>
            </th>
        </tr>
    </thead>
    <tfoot>
		<tr>
			<td colspan="7">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
    <tbody>
    <?php foreach ($this->items as $i => $item) :
        $canChange	= $user->authorise('core.edit.state', 'com_helpdesk');
    ?>
        <tr class="row<?php echo $i % 2; ?>">
            <td>
				<?php echo JHtml::_('grid.id', $i, $item->id); ?>
			</td>
            <td>
                <?php echo $item->hname; ?>
            </td>
            <td>
				<a href="<?php echo JRoute::_( 'index.php?option=com_helpdesk&task=entry.edit&id='.$item->id); ?>">
					<?php echo substr($item->htext,0,50)."..."; ?></a>
            </td>
            <td>
                <?php
		switch($item->hstatus) {
			case '-1':
				echo '<span class="helpdesk-declined">'.JText::_('COM_HELPDESK_DECLINED').'</span>';
				break;
			case '0':
				echo '<span class="helpdesk-not-in-progress">'.JText::_('COM_HELPDESK_NOT_IN_PROGRESS').'</span>';
				break;
			case '1':
				echo '<span class="helpdesk-in-progress">'.JText::_('COM_HELPDESK_IN_PROGRESS').'</span>';
				break;
			case '2':
				echo '<span class="helpdesk-finished">'.JText::_('COM_HELPDESK_FINISHED').'</span>';
				break;
		}
		?>
			</td>
			<td class="center">
				<?php echo JHtml::_('jgrid.published', $item->published, $i, 'helpdesk.', $canChange);?>
			</td>
			<td>
                <?php echo JHtml::_('date', $item->hdate, JText::_('DATE_FORMAT_LC2')) ?>
            </td>
			<td>
				<?php if ($item->hcomment){ echo '<img src="images/tick.png" alt="Has a comment" />';} ?>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>

    <input type="hidden" name="option" value="com_helpdesk" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHtml::_('form.token'); ?>
</form>
