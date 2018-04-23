<?php
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view');

class Onion_projectViewHome extends JViewLegacy
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
	   		JToolBarHelper::title( JText::_('新增'),'generic.png' );
		} else {
	   		JToolBarHelper::title( JText::_('編輯'),'generic.png' );
		}
		
    	JToolBarHelper::apply('home.apply');
		//JToolBarHelper::custom( 'home_save', 'save', 'save', '儲存', false, false );
    	JToolBarHelper::save('home.save');
    	//JToolBarHelper::save2new('home.save2new');
    	// JToolBarHelper::cancel('home.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
    	JToolbarHelper::cancel('home.cancel');
		
    	$this->item = $item;
    	$this->form = $form;
    	parent::display($tpl);
    	$document = JFactory::getDocument();
    }  
}