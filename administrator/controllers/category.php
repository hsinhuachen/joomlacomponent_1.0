<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controllerform');

class Onion_projectControllerCategory extends JControllerForm
{

    function __construct() {
        $this->view_list = 'categories';
		
        parent::__construct();
    }

}