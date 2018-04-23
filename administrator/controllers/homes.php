<?php

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

class Onion_projectControllerHomes extends JControllerAdmin
{
	public function getModel($name = 'Home', $prefix = 'Onion_projectModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
	
	/*function delete(){
		parent::delete();	
		$delId = $_POST["cid"];	
	}*/
}