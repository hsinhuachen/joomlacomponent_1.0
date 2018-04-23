<?php
defined('_JEXEC') or die;

jimport( 'joomla.application.component.modellist' );

class Onion_projectModelNews extends JModelList
{
	public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id',
                'title',
				'message',
				'photo',
				'year',
                'ordering',
				'state'
            );
        }

        parent::__construct($config);
    }
	
	function getListQuery(){
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
        $query->select('id, title, year, latest, ordering, state');
        $query->from('#__onion_news');

		// Filter by search in title
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

        $search = $this->getState('filter.search');
        if (!empty($search)) {
			$search = $db->Quote('%' . $db->escape($search, true) . '%');
			$query->where('( title LIKE '. $search .' )');
        }

         // Filter by year
        $year = $db->escape($this->getState('filter.year'));
        if(!empty($year)){
        	$query->where('(year='.$year.')');
    	}

		$query->order('latest desc, year desc, ordering desc');
        return $query;
	}
	
	 protected function populateState($ordering = null, $direction = null){
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', preg_replace('/\s+/',' ', $search));

		//Filter (dropdown) category
		$year = $app->getUserStateFromRequest($this->context.'.filter.year', 'filter_year', '', 'string');
		$this->setState('filter.year', $year);

		//Takes care of states: list. limit / start / ordering / direction
		parent::populateState('a.ordering', 'desc');
	}

	
}
