<?php
defined('_JEXEC') or die ('Restricted access');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div id="editcell">
    <table class="adminlist">
    <thead>
        <tr>
            <th width="20">
    			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th width="40">
                <?php echo JText::_('COM_HELPDESK_AUTHOR'); ?>
            </th>
            <th>
                <?php echo JText::_('COM_HELPDESK_MESSAGE'); ?>
            </th>
            <th>
                <?php echo JText::_('COM_HELPDESK_DATE'); ?>
            </th>
            <th>
                <?php echo JText::_('COM_HELPDESK_STATUS'); ?>
            </th>
            <th>
                <?php echo JText::_('COM_HELPDESK_COMMENT'); ?>
            </th>
            <th>
                <?php echo JText::_('JPUBLISHED'); ?>
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
    <?php
    $k = 0;
    for ($i=0, $n=count( $this->items ); $i < $n; $i++) {
        $row =& $this->items[$i];
//print_r ($row);
        $link = JRoute::_( 'index.php?option=com_helpdesk&controller=entry&task=edit&cid[]='. $row->id );
    ?>
        <tr class="<?php echo "row$k"; ?>">
            <td>
  				  <?php echo JHtml::_( 'grid.id', $i, $row->id ); ?>
			</td>
            <td>
                <?php echo $row->hname; ?>
            </td>
            <td>
                <span class="hasTip" title="<?php echo $row->htext?>"><a href="<?php echo $link ?>"><?php echo substr($row->htext,0,50)."..."; ?></a></span>
            </td>
            <td>
                <?php echo JHtml::_('date', $row->hdate, JText::_('DATE_FORMAT_LC2')) ?>
            </td>
            <td>
                <?php
		switch($row->hstatus) {
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
			<td>
				<?php if($row->hcomment){ echo '<img src="images/tick.png" class="hasTip" title="'.$row->hcomment.'" alt="Has a comment" />';} ?>
			</td>
			<td class="center">
				<?php echo JHtml::_('grid.published', $row, $i ); ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}?>
	</tbody>
    </table>

    <input type="hidden" name="option" value="com_helpdesk" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="controller" value="entry" />
	<?php echo JHtml::_('form.token'); ?>
</div>
</form>
<div class="padding">
</div>

