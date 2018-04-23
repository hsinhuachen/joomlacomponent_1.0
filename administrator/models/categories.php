<?php
defined('_JEXEC') or die;

jimport( 'joomla.application.component.modellist' );

class Onion_projectModelCategories extends JModelList
{
	public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id',
                'title',
				'parents',
                'ordering',
                'state'
            );
        }

        parent::__construct($config);
    }
	
	function getListQuery(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
        $query->select('id, title, ordering, state');
        $query->from('#__onion_category');
		$query->where('type="project"');
		$query->order('ordering desc');

		// Filter by search in title
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

        $search = $this->getState('filter.search');
        if (!empty($search)) {
			$search = $db->Quote('%' . $db->escape($search, true) . '%');
			$query->where('( title LIKE '. $search .' )');
        }
		
        return $query;
	}
	
	 protected function populateState($ordering = null, $direction = null){
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', preg_replace('/\s+/',' ', $search));

		//Takes care of states: list. limit / start / ordering / direction
		parent::populateState('a.ordering', 'desc');
	}
}
