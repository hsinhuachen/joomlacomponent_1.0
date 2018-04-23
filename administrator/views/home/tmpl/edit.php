<?php

// no direct access
defined('_JEXEC') or die;

$option = JRequest::getCmd('option');
$user	= JFactory::getUser();
$userId	= $user->get('id');
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

$document = JFactory::getDocument();
$document->addStyleSheet('components/com_onion_project/assets/admin.css');
// $document->addScriptDeclaration('');


JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
$getField = JFormHelper::loadFieldType('Onionproject', false);
$maxOrdering = $getField->getMaxOrdering($this->item->ordering,'#__onion_slide');
$isNew = ($this->item->id < 1);
?>
<script src="components/com_onion_project/assets/admin.js" type="text/javascript"></script>
<form action="<?php echo JRoute::_('index.php?com_onion_projects') ?>" method="post" name="adminForm" id="single-admin-form"  enctype="multipart/form-data" class="form-validate">
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
    <input type="hidden" name="jform[created_by]" value="<?php echo $userId; ?>" />
	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
	<?php echo JHtml::_('form.token'); ?>
    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'ID-Tabs-Group', array('active' => 'general')); ?>
        <?php echo JHtml::_('bootstrap.addTab', 'ID-Tabs-Group', 'general', "內容"); ?>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('title'); ?></div>
            </div> <!-- /control-group -->
            <div class="control-group">
                <div class="control-label"><label for="jform_photo" class="">清單圖片</label></div>
                <div class="controls">
                    <div id="previewImg" class="preview">
                        <?php
                            $uploadText = "選擇圖片";
                            if(!empty($this->item->photo)){
                                echo '<img src="' . $root . $this->item->photo . '" alt="">';
                                echo '<a href="' . $root . $this->item->photo . '" data-id="previewImg" data-name="checkPhoto" class="delImgBtn icon-32-cancel"></a>';
                                $uploadText = "更換圖片";
                            }
                        ?>
                    </div>
                    <div class="att">
                        <div class="filetext"><button id="uploadbtn" class="uploadButton" type="button"><?php echo $uploadText; ?></button><span>圖片尺寸寬700px高430px, 需以英文命名, jpg格式</span><div class="clr"></div></div>
                        <input type="file" name="jform[photo]" accept="image/jpeg" id="jform_post_photo" class="hidefile" onchange="previewPhoto(this,'jform_photo','previewImg')">
                        <input type="hidden" name="checkPhoto" id="checkPhoto" />
                    </div>      
                </div> <!-- /controls -->
            </div> <!-- /control-group -->
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'ID-Tabs-Group', 'tab2_id', "Media"); ?>
            <div class="control-group">
                <?php echo $this->form->getInput('myimage'); ?>
            </div> <!-- /control-group -->
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <input type="hidden" name="jform[ordering]" id="jform_ordering" value="<?php echo $maxOrdering;  ?>" class="" aria-invalid="false">
    </div>
</form>
