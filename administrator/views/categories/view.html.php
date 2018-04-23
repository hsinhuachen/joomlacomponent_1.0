<?php
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class Onion_projectViewCategories extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	
    function display($tpl = null)
    {
		// Toolbar
    	JToolBarHelper::title( "作品/產品類別", '' ); 
    	JToolBarHelper::addNew('Category.add');
    	JToolBarHelper::editList('Category.edit');
    	JToolBarHelper::deleteList( JText::_( '確定刪除?' ), 'categories.delete' );
		
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->searchterms  = $this->state->get('filter.search');
		$this->filterForm = $this->get('FilterForm');
 
		if ($this->getLayout() !== 'modal'){
			// ContentHelper::addSubmenu('categories');
			$this->sidebar = JHtmlSidebar::render();
		}
 
        parent::display($tpl);
    }
}
