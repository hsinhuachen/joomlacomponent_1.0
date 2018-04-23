<?php
defined('_JEXEC') or die;

jimport( 'joomla.application.component.modellist' );

class Onion_projectModelProjects extends JModelList
{
	public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id',
                'title',
				'message',
				'photo',
                'ordering',
				'state'
            );
        }

        parent::__construct($config);
    }
	
	function getListQuery(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
        $query->select('id, title, ordering, latest, state');
        $query->from('#__onion_projects');

		// Filter by search in title
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

        $search = $this->getState('filter.search');
        if (!empty($search)) {
			$search = $db->Quote('%' . $db->escape($search, true) . '%');
			$query->where('( title LIKE '. $search .' )');
        }

         // Filter by category
        $category = $db->escape($this->getState('filter.category'));
        if(!empty($category)){
        	$query->where('(category='.$category.')');
    	}

		$query->order('latest desc, ordering desc');
        return $query;
	}
	
	 protected function populateState($ordering = null, $direction = null){
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', preg_replace('/\s+/',' ', $search));

		//Filter (dropdown) category
		$category = $app->getUserStateFromRequest($this->context.'.filter.category', 'filter_category', '', 'string');
		$this->setState('filter.category', $category);

		//Takes care of states: list. limit / start / ordering / direction
		parent::populateState('a.ordering', 'desc');
	}

	
}
