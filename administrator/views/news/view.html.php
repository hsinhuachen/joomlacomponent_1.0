<?php
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class Onion_projectViewNews extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	
    function display($tpl = null)
    {
		// Toolbar
    	JToolBarHelper::title( "最新消息", '' ); 
    	JToolBarHelper::addNew('single.add');
    	
    	JToolBarHelper::deleteList( JText::_( '確定刪除?' ), 'news.delete' );
		
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->searchterms  = $this->state->get('filter.search');

		// Get filter form.
        $this->filterForm = $this->get('FilterForm');

		if ($this->getLayout() !== 'modal'){
			//$this->sidebar = JHtmlSidebar::render();
		}
 
        parent::display($tpl);
    }
}
