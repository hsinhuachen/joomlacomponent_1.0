<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controllerform');

class Onion_projectControllerProject extends JControllerForm
{

    function __construct() {
        $this->view_list = 'projects';
		
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
		date_default_timezone_set('Asia/Taipei');
		$cur_date = date("Y-n-d H:i:s");
		$updateStr = $updateStr . "modifytime=" . $db->quote($cur_date) . ",";

		// 更新規格
		$labels = JRequest::getVar('speclabel');
		$contents = JRequest::getVar('specInfo');
		$spec = array();
		$specs = "";
		foreach ($labels as $key => $label) {
			if(!empty($label)){
				$spec[$key] = array(
					"label" => $label,
					"content" => $contents[$key]
				);
			}
		}

		//echo '<pre>' . print_r($labels,true) . '</pre>'
		if(count($spec) > 0){
			$specs = serialize($spec);
		}
		$updateStr = $updateStr . "spec=" . $db->quote($specs);

		// 更新相簿
		$photoNames = JRequest::getVar('photoName');
		$photoDescs = JRequest::getVar('photoDesc');
		foreach ($photoNames as $key => $photoName) {
			$gallery[$key] = array(
				"img" => $photoName,
				"desc" => $photoDescs[$key]
			);
		}

		if(count($gallery) > 0){
			$gallerys = serialize($gallery);
		}else{
			$gallerys = "";
		}

		$updateStr = $updateStr . ",gallery=" . $db->quote($gallerys);

		// 更新資料
		$updateSql ="update #__onion_projects set " . $updateStr . " where id=" . $id;
		$db->setQuery($updateSql);
		$updateResult = $db->query();

		// facebook debug
		/*JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
		$getField = JFormHelper::loadFieldType('Onionproject', false);

		$path = 'index.php?option=com_onion_project&view=project&Itemid=137&category=' . $fields["category"] . '&id=' . $id;
		$getField->reload($path); */
	}
	
	/*function edit(){
	 	parent::edit();
	}*/

	/*function cancel(){		
		parent::cancel();
	}*/
}