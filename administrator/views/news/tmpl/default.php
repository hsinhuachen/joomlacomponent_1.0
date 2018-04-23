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
	$saveOrderingUrl = 'index.php?option=com_onion_project&task=news.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$assoc = JLanguageAssociations::isEnabled();

//Get category options
JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
$getField = JFormHelper::loadFieldType('Onionproject', false);
$db  = JFactory::getDbo();
$getYear = JRequest::getVar('filter_year','');
?>
<form action="<?php echo JRoute::_('index.php?option=com_onion_project&view=news'); ?>" method="post" name="adminForm" id="adminForm">
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
		//echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
	
	$document->addStyleSheet('../media/jui/css/jquery.searchtools.css');
	?>
	<div class="js-stools clearfix">
		<div class="clearfix">
			<div class="js-stools-container-bar">
				<label for="filter_search" class="element-invisible">搜尋</label>
				<div class="btn-wrapper input-append">
					<input type="text" name="filter[search]" id="filter_search" value="" placeholder="搜尋" data-original-title="" title="">
						<button type="submit" class="btn hasTooltip" title="" data-original-title="搜尋">
						<span class="icon-search"></span>
					</button>
				</div>
				<div class="btn-wrapper input-append"><button type="button" class="btn hasTooltip js-stools-btn-clear" title="" data-original-title="清除">清除</button></div>
			</div>
			<div class="js-stools-container-list hidden-phone hidden-tablet shown" style="">
				<select name="filter_year" class="inputbox" onchange="this.form.submit()">
		            <option value="">年份</option>
		            <?php
		            	$db->setQuery("select year from #__onion_news where 1 group by year desc");
		
						$years = $db->loadColumn();
						foreach ($years as $key => $year) {
							if($year == $getYear){
								echo '<option value="' . $year . '" selected="">' . $year . '</option>';
							}else{
								echo '<option value="' . $year . '">' . $year . '</option>';
							}
						}
		            ?>
		        </select>
			</div>
			<?php
				/* total */
				$filter = JRequest::getVar('filter');
				$keyword = $filter["search"];

				if(!empty($keyword)){
					$search = $db->Quote('%' . $db->escape($keyword, true) . '%');
					$countWhere = " where title like " . $search;
				}else{
					$countWhere = "";
				}

				$db->setQuery("select count(*) from #__onion_news" . $countWhere);
				$count = $db->loadResult();
				
				echo '<span style="margin: 5px 0 0 5px; display: inline-block">共 ' . $count . ' 筆資料</span>';
			?>
		</div>
	</div> <!-- /js-stools -->
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
				<th class='left'>標題</th>
				<th class='left' width="5%">年份</th>
				<th class='left' width="5%">置頂</th>
                <th class='left' width="5%">發佈</th>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php
                $number = 1;
                foreach ($this->items as $i => $item){
                    $link = JRoute::_( 'index.php?option=' . $option . '&task=single.edit&id=' . $item->id );
                    $ordering	= ($listOrder == 'a.ordering');
                    $canChange	= $user->authorise('core.edit.state',	'com_onion_project');
            ?>
                <tr>
                    <td class="center itemid"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
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
                    <td><?php echo $item->year; ?></td>
                    <td class="center">
                    	<?php
                    		if($item->latest == 1){
                    	?>
                    	<a class="btn btn-micro active hasTooltip" href="javascript:void(0);" onclick="latest(this,0)" title="" data-original-title="停止置頂此項目"><span class="icon-publish"></span></a>
                    	<?php
                    		}else{
                    	?>
                    	<a class="btn btn-micro hasTooltip" href="javascript:void(0);" onclick="latest(this,1)" title="" data-original-title="置頂此項目"><span class="icon-unpublish"></span></a>
                    	<?php
                    		}
                    	?>
                    </td>
					<td class="center">
						<?php echo JHtml::_('jgrid.published', $item->state, $i, 'news.', $canChange, 'cb'); ?>
                    </td>
                </tr>
            <?php
                }
            ?>
		</tbody>
	</table>
	<?php endif;?>
	</div> <!-- /j-main-containe -->
	<div>
		<input type="hidden" name="target" value="#__onion_news" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<script type="text/javascript">
function latest(obj,checked){
	jQuery(obj).parents("tr").find('.itemid input:checkbox').attr('checked', "checked");

    if (checked == 0) {
		Joomla.submitform('latest1');
    } else {
		Joomla.submitform('latest2');
    }
}
</script>