<?php
/**
 * @version     1.0.0
 * @package     com_onion_project
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      hsnihuachen <yha0971@gmail.com> - http://www.oniondesign.com.tw
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller	= JController::getInstance('Onion_project');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
