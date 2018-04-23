<?php
defined('_JEXEC') or die();
 
jimport( 'joomla.application.component.modeladmin' );
 
class Onion_projectModelHome extends JModelAdmin
{	
	/*public function getTable($type = 'home', $prefix = 'onion_projectTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}*/
	
	 public function getForm($data = array(), $loadData = true)
    {
        // Get the form
        $form = $this->loadForm('com_onion_project.home', 'home', array('control' => 'jform', 'load_data' => $loadData));
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