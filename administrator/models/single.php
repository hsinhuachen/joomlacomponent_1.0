<?php
defined('_JEXEC') or die();
 
jimport( 'joomla.application.component.modeladmin' );
 
class Onion_projectModelSingle extends JModelAdmin
{	
	
	 public function getForm($data = array(), $loadData = true)
    {
        // Get the form
        $form = $this->loadForm('com_onion_project.single', 'single', array('control' => 'jform', 'load_data' => $loadData));
        if (!$form) {
            return false;
        } else {
            return $form;
        }
    }
    public function loadFormData()
    {
        // Load form data
        $data = $this->getItem();
        return $data;
    }
}