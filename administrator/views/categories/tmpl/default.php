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
	$saveOrderingUrl = 'index.php?option=com_onion_project&task=categories.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$assoc = JLanguageAssociations::isEnabled();

//Get category options
JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
$getField = JFormHelper::loadFieldType('Onionproject', false);
?>
<form action="<?php echo JRoute::_('index.php?option=com_onion_project&view=categories'); ?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty( $this->sidebar)) : ?>
		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>
		</div>
		<div id="j-main-container" class="span10">
	<?php else : ?>
		<div id="j-main-container">
	<?php endif;?>
	<?php
		// Search tools bar
		echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
	?>
	<?php if (empty($this->items)) : ?>
		<div class="alert alert-no-items">
			<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
		</div>
	<?php else : ?>
	<table class="table table-striped" id="articleList">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
				</th>
                <th class='left' width="10%">排序</th>
				<th class='left'>類別名稱</th>
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
                    $link = JRoute::_( 'index.php?option=' . $option . '&task=category.edit&id=' . $item->id );
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
							<input type="text" name="order[]" size="5" style="display:none" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
						<?php endif; ?>
                    </td>
                    <td><a href="<?php echo $link; ?>"><?php echo nl2br($item->title); ?></a></td>
                    <td class="center">
						<?php echo JHtml::_('jgrid.published', $item->state, $i, 'categories.', $canChange, 'cb'); ?>
                    </td>
                </tr>
            <?php
                }
            ?>
			</tr>
		</tbody>
	</table>
	<?php endif;?>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>