<?php
/**
 * display the module home page
 * @author Micah Carter <mcarter at tux dot appstate dot edu>
 **/

class GolferHomeUI {
    public $errorMsg = NULL;

    public function display($error) {
        $tags = array();
        $tags['TITLE']              = "phpGolfer";
        $tags['ADD_GOLFER_LINK']    = PHPWS_Text::secureLink('Add a Golfer','golfer', array('action' => 'add_golfer'));
        $tags['UPDATE_HC_LINK']     = PHPWS_Text::secureLink('Update Handicaps','golfer', array('action' => 'recalc_all'));
        $tags['ERROR']              = $error;

        PHPWS_Core::initModClass('golfer','Golfer.php');
        $pager = new DBPager('golfer_golfer','Golfer');
        $pager->setModule('golfer');
        $pager->setTemplate('Golfer_Home.tpl');
        $pager->allowPartialReport(false);
        $pager->setOrder('name','asc');
        $pager->addToggle('');
        $pager->addToggle(' style="background-color: white;"');
        $pager->addRowTags('get_row_tags');

        $pager->addPageTags($tags);
        Layout::add($pager->get());

    }
}
?>
