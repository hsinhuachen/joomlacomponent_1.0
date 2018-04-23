<?php
/**
 * @version     1.0.0
 * @package     com_onion_project
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      hsnihuachen <yha0971@gmail.com> - http://www.oniondesign.com.tw
 */
	// no direct access
	defined('_JEXEC') or die;
	$db  = JFactory::getDbo();
	$id = JRequest::getInt('id',0);
	$sql = "select * from #__onion_projects where id='" . $id . "'";
	$db->setQuery($sql);
	$result = $db->loadAssoc();
?>
<article id="article">
	
</article>