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
        if (task == "single.cancel" || document.formvalidator.isValid(document.getElementById("single-admin-form")))
        {
            Joomla.submitform(task, document.getElementById("single-admin-form"));
        }
    };
');


$document = JFactory::getDocument();
$document->addStyleSheet('components/com_onion_project/assets/admin.css');

JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
$getField = JFormHelper::loadFieldType('Onionproject', false);
$maxOrdering = $getField->getMaxOrdering($this->item->ordering,'#__onion_news');
$isNew = ($this->item->id < 1);
$root = "../images/news/";
$galleryRoot = "../images/news/";
date_default_timezone_set('Asia/Taipei');
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<script src="components/com_onion_project/assets/admin.js?2018" type="text/javascript"></script>
<form action="<?php echo JRoute::_('index.php?com_onion_projects') ?>" method="post" name="adminForm" id="single-admin-form"  enctype="multipart/form-data" class="form-validate">
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
    <input type="hidden" name="jform[account]" value="<?php echo $userId; ?>" />
	<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
	<?php echo JHtml::_('form.token'); ?>
    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'ID-Tabs-Group', array('active' => 'info')); ?>
        <?php echo JHtml::_('bootstrap.addTab', 'ID-Tabs-Group', 'info', "基本資訊"); ?>
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('title'); ?></div>
        </div> <!-- /control-group -->
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('year');  ?></div>
            <div class="controls">
                <?php //echo $this->form->getInput('year'); ?>
                <input type="text" name="jform[year]" id="jform_year" class="normal" aria-invalid="false" value="<?php echo $this->item->year; ?>" placeholder="<?php echo date("Y"); ?>">
            </div>
        </div> <!-- /control-group -->
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('date'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('date'); ?></div>
        </div> <!-- /control-group -->
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('excerpt'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('excerpt'); ?></div>
        </div> <!-- /control-group -->
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('message'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('message'); ?></div>
        </div> <!-- /control-group -->
        <div class="control-group">
            <div class="control-label"><label for="jform_thumb" class="">清單圖片</label></div>
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
                    <div class="filetext"><button id="uploadbtn" class="uploadButton" type="button"><?php echo $uploadText; ?></button><span>圖片尺寸寬240px高240px, 需以英文命名, jpg格式</span><div class="clr"></div></div>
                    <input type="file" name="jform[photo]" accept="image/jpeg" id="jform_post_photo" class="hidefile" onchange="previewPhoto(this,'jform_photo','previewImg')">
                    <input type="hidden" name="checkPhoto" id="checkPhoto" />
                </div>      
            </div> <!-- /controls -->
        </div> <!-- /control-group -->
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php echo JHtml::_('bootstrap.addTab', 'ID-Tabs-Group', 'gallery', "相簿"); ?>
        <?php
            $galleryText = "選擇圖片";
        ?>
        <div class="att">
            <div class="filetext"><button id="uploadbtn" class="uploadButton" type="button"><?php echo $galleryText; ?></button><span>圖片尺寸寬700px高430px, 需以英文命名, jpg格式</span><div class="clr"></div></div>
            <input type="file" name="jform[gallery][]" multiple="multiple" accept="image/jpeg" id="jform_post_gallery" class="hidefile" onchange="multiplePhoto(this)" >
        </div>    
        <div id="galleryList" class="ui-sortable">
            <?php
                $galleryStr = unserialize($this->item->gallery);
                if(is_array($galleryStr)){
                    foreach ($galleryStr as $key => $gallery) {
                        echo '<div id="photo' . $key . '" class="gallery-img updateImg">';
                        echo '<input type="hidden" name="photoName[]" value="' . $gallery["img"] . '" />';
                        echo '<img src="' . $galleryRoot . $gallery["img"] . '" alt="" class="previewImg" />';
                        echo '<textarea name="photoDesc[]" placeholder="圖說" class="middle">' . $gallery["desc"] . '</textarea>';
                        echo '<a href="' . $galleryRoot . $gallery["img"] . '" delid="' . $this->item->id . '" class="delImgBtn2 icon-32-cancel"></a>';
                        echo '<div class="clear"></div>';
                        echo '</div>';
                    }
                }
            ?>
        </div> <!-- /galleryList --> 
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php
            if(empty($this->item->datetime) || $this->item->datetime == "0000-00-00 00:00:00"){
                $date = date("Y-m-d H:i:s");
            }else{
                $date = $this->item->datetime;
            }
        ?>
        <input type="hidden" name="jform[datetime]" id="jform_datetime" value="<?php echo $date; ?>" class="">
        <input type="hidden" name="jform[ordering]" id="jform_ordering" value="<?php echo $maxOrdering;  ?>" class="" aria-invalid="false">
    </div> <!-- /form-horizontal -->

</form>