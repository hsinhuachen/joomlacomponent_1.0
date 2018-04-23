<?php
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class Onion_projectViewProjects extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	
    function display($tpl = null)
    {
		// Toolbar
    	JToolBarHelper::title( "作品 / 產品", '' ); 
    	JToolBarHelper::addNew('project.add');
    	
    	JToolBarHelper::deleteList( JText::_( '確定刪除?' ), 'projects.delete' );
		
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->searchterms  = $this->state->get('filter.search');

		// Get filter form.
        $this->filterForm = $this->get('FilterForm');

		if ($this->getLayout() !== 'modal'){
			//ContentHelper::addSubmenu('projects');
			$this->sidebar = JHtmlSidebar::render();
		}
 
        parent::display($tpl);
    }
}
