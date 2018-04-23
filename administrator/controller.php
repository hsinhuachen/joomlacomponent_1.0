<?php

// No direct access
defined('_JEXEC') or die;

class Onion_projectController extends JControllerLegacy
{
	public function display($cachable = false, $urlparams = false)
	{	
		// Set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'homes'));

		$this->addSubmenu();
		parent::display($cachable);
	}
	
	public static function addSubmenu(){
		$cmd = JRequest::getCmd('view', 'projects');

		JHtmlSidebar::addEntry("作品", 'index.php?option=com_onion_project&view=projects', $cmd == 'projects');
		JHtmlSidebar::addEntry("作品類別", 'index.php?option=com_onion_project&view=categories', $cmd == 'categories');
	}
	
	function delimg(){
		$delfile = JRequest::getVar('file');
		
		if (!file_exists($delfile)) return true;   
		if (!is_dir($delfile ) || is_link($delfile)) return unlink($delfile); 
	}

	function latest1(){
		$cids = JRequest::getVar('cid');
		$target = JRequest::getVar('target');

		$db  = JFactory::getDbo();
		$sqlstr="update " . $target . " set latest=0 where ID=" . $cids[0];
		$db->setQuery($sqlstr);
		$db->query();
		
		$return = JURI::getInstance()->toString();
		$msg = JText::_( '已取消置頂' );
        $this->setRedirect( $return, $msg );
	}

	function latest2(){
		$cids = JRequest::getVar('cid');
		$target = JRequest::getVar('target');

		$db  = JFactory::getDbo();
		$sqlstr="update " . $target . " set latest=1 where ID=" . $cids[0];
		$db->setQuery($sqlstr);
		$db->query();
		
		$return = JURI::getInstance()->toString();
		$msg = JText::_( '已置頂' );
        $this->setRedirect( $return, $msg );
	}
}
