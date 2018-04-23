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

$app = JFactory::getApplication();
$db  = JFactory::getDbo();
$catID = JRequest::getInt('catID',0);
?>
<h1 class="hidden"><?php echo htmlspecialchars($app->getCfg('sitename')); ?></h1>
<div class="tab">
    <ul>
        <li><a href="index.php" class="current">All</a></li>
        <?php
            $tabSql = "select id,title_en from #__onion_category where parents='0' order by ordering desc limit 0,10";
            $db->setQuery($tabSql);
            $tabs = $db->loadAssocList();
            
            foreach ($tabs as $key => $tab) {
                echo '<li><a href="index.php?category=' . $tab["id"] . '">' . $tab["title"] . '</a></li>';
            }
        ?>
    </ul>
</div>
<div id="isotope">
<?php
    if($categoryID == 0){
        $where = "where 1";
    }else{
        $where = "where category=" . $categoryID; 
    }

    $sql = "select * from #__onion_projects " . $where . " order by datetime desc limit 0,15";
    $db->setQuery($sql);
    $rows = $db->loadAssocList();  

    foreach ($rows as $key => $item) {
        if(file_exists($item["thumb"]) || !empty($item["thumb"])){
            $img = imagecreatefromjpeg($item["thumb"]);
            $imgW = imagesx($img);
            $imgH = imagesy($img);

            $imgItem = '<img src="' . $item["thumb"] .'" width="' . $imgW . '" height="' . $imgW . '" alt="" />';
        }else{
            $imgItem = "";
        }

?>
    <div class="isotope-item">
        <a href="<?php echo JRoute::_('index.php?option=com_onion_project&view=project&id=' . $item["id"]); ?>">
            <div class="img"><?php echo $imgItem; ?></div>
            <div class="feature">
                <p class="tag"><?php echo $categoryName; ?></p>
                <h2><?php echo nl2br($item["title"]) ?></h2>
            </div> <!-- /feature -->
        </a>
    </div> <!-- /isotope-item -->
    <?php
        } // end foreach
    ?>
</div> <!-- /isotope -->
    