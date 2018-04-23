<?php

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

class Onion_projectControllerNews extends JControllerAdmin
{	
	public function getModel($name = 'Single', $prefix = 'Onion_projectModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		
		return $model;
	}  

	function delete(){
		parent::delete();
		$cid = JRequest::getVar('cid');
	}
}