<?php
defined('_JEXEC') or die;

jimport( 'joomla.application.component.modellist' );

class Onion_projectModelHomes extends JModelList
{
	public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id',
                'title',
				'message',
				'link',
				'photo',
				'category',
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
        $query->from('#__onion_slide');

        // Filter by search in title
        $search = $this->getState('filter.search');	
        if (!empty($search)) {
			$keyword = $db->Quote('%' . $db->escape($search, true) . '%');

			if(is_numeric($keyword)){
				$query->where('( title LIKE '. $keyword . ' or id =' . $search . ')');
			}else{
				$query->where('( title LIKE binary '. $keyword . ')');
			}
        }

		$query->order('ordering desc');
        return $query;
	}
	
	 protected function populateState($ordering = null, $direction = null){
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', preg_replace('/\s+/',' ', $search));

		//Takes care of states: list. limit / start / ordering / direction
		parent::populateState('a.ordering', 'desc');
	}
}
