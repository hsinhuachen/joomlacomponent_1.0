<?php

// no direct access
defined('_JEXEC') or die;

$option = JRequest::getCmd('option');
$user   = JFactory::getUser();
$userId = $user->get('id');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.modal');
jimport ('joomla.html.html.bootstrap');
$this->ignore_fieldsets = array('jmetadata', 'item_associations');

JFactory::getDocument()->addScriptDeclaration('
    Joomla.submitbutton = function(task)
    {
        if (task == "home.cancel" || document.formvalidator.isValid(document.getElementById("single-admin-form")))
        {
            Joomla.submitform(task, document.getElementById("single-admin-form"));
        }
    };
');

JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
$getField = JFormHelper::loadFieldType('Onionproject', false);
$maxOrdering = $getField->getMaxOrdering($this->item->ordering,'#__onion_category');

$isNew = ($this->item->id < 1);
?>
<form action="<?php echo JRoute::_('index.php?com_onion_projects') ?>" method="post" name="adminForm" id="single-admin-form"  enctype="multipart/form-data" class="form-validate">
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
    <input type="hidden" name="jform[created_by]" value="<?php echo $userId; ?>" />
	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
	<?php echo JHtml::_('form.token'); ?>
    <div class="form-horizontal">
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('title'); ?></div>
        </div> <!-- /control-group -->
        <input type="hidden" name="jform[ordering]" id="jform_ordering" value="<?php echo $maxOrdering;  ?>" class="" aria-invalid="false">
        <input type="hidden" name="jform[type]" value="project" />
    </div> <!-- /form-horizontal -->
</form>