<?php
// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user	= JFactory::getUser();
$userId	= $user->get('id');
$option = JRequest::getCmd('option');
$view = JRequest::getCmd('view');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_onion_product');
$saveOrder	= $listOrder == 'a.ordering';

$document = JFactory::getDocument();
$document->addStyleSheet('components/com_onion_project/assets/admin.css');

if ($saveOrder){
	$saveOrderingUrl = 'index.php?option=com_onion_project&task=homes.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$assoc = JLanguageAssociations::isEnabled();
?>
<form action="<?php echo JRoute::_('index.php?option=com_onion_project&view=homes'); ?>" method="post" name="adminForm" id="adminForm">
	<?php
		// Search tools bar
		echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
	?>
	<table class="table table-striped" id="articleList">
		<thead>
			<tr>
				<th width="1%">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>
                <th class='center' width="10%">
					<?php //echo JHtml::_('searchtools.sort', '', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
					排序
                </th>
				<th class='left'>標題</th>
                <th class='left' width="5%">發佈</th>
		</thead>
		<tfoot>
			<tr>
				<td colspan="4">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php
                $number = 1;
                foreach ($this->items as $i => $item){
                    $link = JRoute::_( 'index.php?option=' . $option . '&task=home.edit&id=' . $item->id );
                    $ordering	= ($listOrder == 'a.ordering');
                    $canChange	= $user->authorise('core.edit.state',	'com_onion_project');
            ?>
                <tr>
                    <td class="center"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
                    <td class="center order">
						<?php
							$iconClass = '';
							if (!$canChange){
								$iconClass = ' inactive';
							}elseif (!$saveOrder){
								$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
							}
						?>
						<span class="sortable-handler<?php echo $iconClass ?>">
							<span class="icon-menu"></span>
						</span>
						<?php if ($canChange && $saveOrder) : ?>
							<input type="text" name="order[]" style="display:none" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
						<?php endif; ?>
                    </td>
                    <td><a href="<?php echo $link; ?>"><?php echo nl2br($item->title); ?></a></td>
					<td class="center">
						<?php echo JHtml::_('jgrid.published', $item->state, $i, 'homes.', $canChange, 'cb'); ?>
                    </td>
                </tr>
            <?php
                }
            ?>
		</tbody>
	</table>

	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>