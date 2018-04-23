<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controllerform');

class Onion_projectControllerSingle extends JControllerForm
{

    function __construct() {
        $this->view_list = 'news';
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
		$getField = JFormHelper::loadFieldType('Onionproject', false);
		$this->curDate = $getField->getCurDate();

        parent::__construct();
    }

    function save(){		
		parent::save();
		$db     = JFactory::getDbo();
		$query  = $db->getQuery(true);
		$lastinsertid = $db->insertid();

		$id 	= JRequest::getVar('id');
		$fields = JRequest::getVar('jform');
		$updateStr = "";

		// 增加新頁面時 create new page
		if(empty($id)){
			$id = $lastinsertid;
		}
		
		// 檢查清單圖片
		$checkPhoto = JRequest::getVar('checkPhoto');
		if(!empty($checkPhoto)){
			$updateStr = $updateStr . "photo='',";
		}

		// 更新時間
		$cur_date = $this->curDate;
		$updateStr = $updateStr . "modifytime=" . $db->quote($cur_date);

		// 更新資料
		$updateSql ="update #__onion_news set " . $updateStr . " where id=" . $id;
		$db->setQuery($updateSql);
		$updateResult = $db->query();
	}
	
	// function edit(){
	// 	parent::edit();
	// }

	// function cancel(){		
	// 	parent::cancel();
	// }
}