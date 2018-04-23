<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

class TableHome extends JTable
{
    function __construct( &$db ) {		
    	parent::__construct('#__onion_slide', 'id', $db);
    }
	
	public function bind($array, $ignore = '') {
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
        $getField = JFormHelper::loadFieldType('Onionproject', "false");

		if(isset($_FILES['jform']['name']['photo'])){
            $array['photo'] = $getField->uploadImg("photo","../images/","true");
        } // end if
		
		return parent::bind($array, $ignore);
	}
	
	public function publish($pks = null, $state = 1, $userId = 0) {
        // Initialise variables.
        $k = $this->_tbl_key;

        // Sanitize input.
        JArrayHelper::toInteger($pks);
        $userId = (int) $userId;
        $state = (int) $state;

        // If there are no primary keys set check to see if the instance key is set.
        if (empty($pks)) {
            if ($this->$k) {
                $pks = array($this->$k);
            }
            // Nothing to set publishing state on, return false.
            else {
                $this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
                return false;
            }
        }

        // Build the WHERE clause for the primary keys.
        $where = $k . '=' . implode(' OR ' . $k . '=', $pks);

        // Update the publishing state for rows with the given primary keys.
        $this->_db->setQuery(
                'UPDATE `' . $this->_tbl . '`' .
                ' SET `state` = ' . (int) $state .
                ' WHERE (' . $where . ')'
        );
        $this->_db->query();
		
        // Check for a database error.
        if ($this->_db->getErrorNum()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        // If the JTable instance value is in the list of primary keys that were set, set the instance.
        if (in_array($this->$k, $pks)) {
            $this->state = $state;
        }

        $this->setError('');
		
        return true;
    }
}
