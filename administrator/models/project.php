<?php
defined('_JEXEC') or die();
 
jimport( 'joomla.application.component.modeladmin' );
 
class Onion_projectModelProject extends JModelAdmin
{	
	/*public function getTable($type = 'project', $prefix = 'onion_projectTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}*/
	
	 public function getForm($data = array(), $loadData = true)
    {
        // Get the form
        $form = $this->loadForm('com_onion_project.project', 'project', array('control' => 'jform', 'load_data' => $loadData));
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