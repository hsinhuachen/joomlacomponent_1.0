<?php
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class Onion_projectViewHomes extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	
    function display($tpl = null)
    {
		// Toolbar
    	JToolBarHelper::title("首頁輪播"); 
    	JToolBarHelper::addNew('home.add');
    	JToolBarHelper::editList('home.edit');
    	JToolBarHelper::deleteList( JText::_( '確定刪除?' ), 'homes.delete' );
		
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->searchterms  = $this->state->get('filter.search');
 		$this->filterForm 	= $this->get('FilterForm');

        parent::display($tpl);
    }
}
