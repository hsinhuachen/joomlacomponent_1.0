<?php
 
defined('JPATH_BASE') or die;
 
jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldOnionproject extends JFormFieldList{
	protected $type = 'ordering';

	public function getMaxOrdering($ordering=0,$dbname="#__onion_slide"){
		if($ordering == 0){
			$db     = JFactory::getDbo();
			$query  = $db->getQuery(true);
	
			$query->select('MAX(ordering)');
			$query->from($dbname);
			$db->setQuery($query);
	
			$maxOrdering = $db->loadResult();
	
			// Check for a database error.
			if ($db->getErrorNum()) {
				JError::raiseWarning(500, $db->getErrorMsg());
			}
	
			if(empty($maxOrdering)){
				$maxOrdering = 0;
			}
	
			return $maxOrdering + 1;
		}else{
			return $ordering;
		}
	}
	
	public function getCateOption($parents=0,$type="project"){
		$db     = JFactory::getDbo();
		$query  = $db->getQuery(true);

		$query->select('id, title');
		$query->from('#__onion_category');
		$query->order('ordering desc');
		$query->where('parents = ' . $parents . ' and type = ' . $db->quote($type));
		$db->setQuery($query);
		
		$lists = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		return $lists;			
	}

	function uploadImg($uploadname,$dir,$rename="true"){
		jimport('joomla.filesystem.file');
			
		$file = $_FILES['jform'];

		//Check if the server found any error.
		$fileError = $file['error'][$uploadname];
		$message = '';
		if($fileError > 0 && $fileError != 4) {
			switch ($fileError) :
				case 1:
					$message = JText::_( 'File size exceeds allowed by the server');
					break;
				case 2:
					$message = JText::_( 'File size exceeds allowed by the html form');
					break;
				case 3:
					$message = JText::_( 'Partial upload error');
					break;
			endswitch;
			if($message != '') :
				JError::raiseWarning(500,$message);
				return false;
			endif;
		}
		else if($fileError == 4){
		}
		else{
			if($rename == "true"){
				date_default_timezone_set('Asia/Taipei');
				//Replace any special characters in the filename
				$filename = explode('.',$file['name'][$uploadname]);
				$filename[0] = date("yndHis");
				$filename = implode('.',$filename);
			}else{
				$filename = $file['name'][$uploadname];
			}

			$uploadPath = $dir . $filename;
			$fileTemp = $file['tmp_name'][$uploadname];

			if(!JFile::exists($uploadPath)):

				if (!JFile::upload($fileTemp, $uploadPath)):

					JError::raiseWarning(500,'Error moving file');

					return false;

				endif;

			endif;			

			return $filename;
		}
	} /* end upload img*/

	function multiple($uploadname="gallery",$dir,$rename="false"){
		jimport('joomla.filesystem.file');
		
		$file = $_FILES['jform'];
		$i = 0;
		if(count($_FILES['jform']['name'][$uploadname])) {
			foreach ($_FILES['jform']['name'][$uploadname] as $key => $uploadfile) {
				//Check if the server found any error.
				$fileError = $file['error'][$uploadname][$key];
				$message = '';

				if($fileError > 0 && $fileError != 4) {
					switch ($fileError) :
						case 1:
							$message = JText::_( 'File size exceeds allowed by the server');
							break;
						case 2:
							$message = JText::_( 'File size exceeds allowed by the html form');
							break;
						case 3:
							$message = JText::_( 'Partial upload error');
							break;
					endswitch;
					if($message != '') :
						return Error::raiseError(500,$message);
					endif;
				}
				else if($fileError == 4){
				}
				else{
					if($rename == "true"){
						date_default_timezone_set('Asia/Taipei');
						$filename = explode('.',$uploadfile);
						$filename[0] = date("yndHis") . "-" . $key;
						$filename = implode('.',$filename);
					}else{
						$filename = $uploadfile;
					}

					$uploadPath = $dir . $filename;
						$fileTemp = $file['tmp_name'][$uploadname][$key];
						$gallery[$key] = $filename;			
					if(!JFile::exists($uploadPath)):

						if (!JFile::upload($fileTemp, $uploadPath)):

							return JError::raiseError(500,'Error moving file');

						endif;

					endif;					
				}
			} // end foreach

			return implode(',',$gallery);
		} // end if
	} /* end multiple */

	function getCurDate(){
		date_default_timezone_set('Asia/Taipei');
		$cur_date = date("Y-n-d H:i:s");
		
		return $cur_date;
	}

	function getLatest(){
		return 100;
	}
}
