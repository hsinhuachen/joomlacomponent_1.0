<?php

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

class Onion_projectControllerCategories extends JControllerAdmin
{
	public function getModel($name = 'Category', $prefix = 'Onion_projectModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}  
}