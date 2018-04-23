<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view');
class Onion_projectViewSingle extends JViewLegacy
{
    function display($tpl = null){
		// Get data from the model
		$item = $this->get( 'Item' );
		$form = $this->get( 'Form' );
		$isNew = ($item->id < 1);

		// Disable main menu
		JRequest::setVar('hidemainmenu', true);
	
		// Toolbar
		if ($isNew) {
	   		JToolBarHelper::title( '新增最新消息','generic.png' );
		} else {
	   		JToolBarHelper::title( '編輯最新消息','generic.png' );
		}
		
    	JToolBarHelper::save('single.save');
    	JToolBarHelper::cancel('single.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
		
    	$this->item = $item;
    	$this->form = $form;
    	parent::display($tpl);
    	$document = JFactory::getDocument();
    }  
}