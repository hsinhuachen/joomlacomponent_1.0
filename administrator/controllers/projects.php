<?php

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

class Onion_projectControllerProjects extends JControllerAdmin
{	
	public function getModel($name = 'Project', $prefix = 'Onion_projectModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		
		return $model;
	}  
}