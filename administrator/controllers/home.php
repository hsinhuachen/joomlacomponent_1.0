<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controllerform');

class Onion_projectControllerHome extends JControllerForm
{

    function __construct() {
        $this->view_list = 'homes';
		
        parent::__construct();
    }
	
	/*function save(){		
		parent::save();
		
	}*/

}