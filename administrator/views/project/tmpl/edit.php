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


$document = JFactory::getDocument();
$document->addStyleSheet('components/com_onion_project/assets/admin.css');

JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
$getField = JFormHelper::loadFieldType('Onionproject', false);
$maxOrdering = $getField->getMaxOrdering($this->item->ordering,'#__onion_projects');
$cateList = $getField->getCateOption(0,"project");
$isNew = ($this->item->id < 1);
$root = "../images/";
$galleryRoot = "../images/";

date_default_timezone_set('Asia/Taipei');
$cur = date("Y-m-d H:i:s"); 
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<script src="components/com_onion_project/assets/admin.js" type="text/javascript"></script>
<form action="<?php echo JRoute::_('index.php?com_onion_projects') ?>" method="post" name="adminForm" id="single-admin-form"  enctype="multipart/form-data" class="form-validate">
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
    <input type="hidden" name="jform[account]" value="<?php echo $userId; ?>" />
    <input type="hidden" name="jform[modifytime]" value="<?php echo $cur; ?>" />
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
            <div class="control-label"><?php echo $this->form->getLabel('category');  ?></div>
            <div class="controls">
                <?php //echo $this->form->getInput('category'); ?>
                <select name="jform[category]" class="inputbox">
                    <?php
                        foreach($cateList as $category){
                            if($category->id == $this->item->category){
                    ?>
                        <option value="<?php echo $category->id; ?>"selected><?php echo $category->title; ?></option>
                    <?php
                            }else {
                    ?>
                        <option value="<?php echo $category->id; ?>"><?php echo $category->title; ?></option>
                    <?php
                            }
                        } //  end foreach
                    ?>
                </select>
            </div>
        </div> <!-- /control-group -->
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('message'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('message'); ?></div>
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
        <?php echo JHtml::_('bootstrap.addTab', 'ID-Tabs-Group', 'spec', "規格"); ?>
        <div class="specs">
            <?php 
                $specs = unserialize($this->item->spec);

                if(is_array($specs)){
                    // echo '<pre>' . print_r($specs,true) . '</pre>';
                    foreach ($specs as $key => $spec) {
            ?>
            <div class="control-group custom-spec">
                <div class="control-label"><textarea name="speclabel[]" class="" placeholder="例:尺寸" aria-invalid="false"><?php echo $spec["label"]; ?></textarea></div>
                <div class="controls"><textarea name="specInfo[]" class="middle" placeholder="內容"><?php echo $spec["content"]; ?></textarea></div>
                <hr class="partline">
            </div>
            <?php
                    } // end foreach
                }else{ // end if
            ?>
            <div class="control-group custom-spec">
                <div class="control-label"><textarea name="speclabel[]" class="" placeholder="例:尺寸" aria-invalid="false"></textarea></div>
                <div class="controls"><textarea name="specInfo[]" class="middle" placeholder="內容"></textarea></div>
                <hr class="partline">
            </div>
            <?php
                } // end if
            ?>
            <div class="control-group custom-spec">
                <div class="control-label"><textarea name="speclabel[]" class="" placeholder="例:尺寸" aria-invalid="false"></textarea></div>
                <div class="controls"><textarea name="specInfo[]" class="middle" placeholder="內容"></textarea></div>
                <hr class="partline">
            </div>
        </div> <!-- /specs -->

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
        <input type="hidden" name="jform[ordering]" id="jform_ordering" value="<?php echo $maxOrdering;  ?>" class="" aria-invalid="false">
    </div> <!-- /form-horizontal -->
</form>
<script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script src="components/com_onion_project/assets/jquery-wdragsort.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(function($){
        $(".specs").on('click', ".custom-spec:last",function(event) {
            event.preventDefault();
            $(this).after($(this).clone());
        });
    })
</script>