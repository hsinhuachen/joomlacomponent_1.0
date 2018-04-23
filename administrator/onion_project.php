<?php

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

$document = JFactory::getDocument();
JLoader::register('OnionProjectHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'onion_project.php');
$controller = JControllerLegacy::getInstance('Onion_project');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
