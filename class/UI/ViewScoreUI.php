<?php
/**
 * Adding a golfer
 * @author Micah Carter <mcarter at tux dot appstate dot edu>
**/

class ViewScoreUI {
    public function showScores($id=NULL) {
        if(!$id) {
            return;
            //TODO: something smarter here
        }

        // Page tags
        PHPWS_Core::initModClass('golfer','Golfer.php');
        $golfer = new Golfer($id);
        $gname = $golfer->name;

        $tags = array();
        $tags['TITLE']          = "Scores for $gname";
        $tags['HOME_LINK']      = PHPWS_Text::moduleLink('Back to Golfer Home','golfer');

        //Form stuff
        $form = new PHPWS_Form('add_score');
        $form->setAction('index.php?module=golfer');
        $form->addHidden('action','add_score');
        $form->addSubmit('submit','Add Score');
        $form->addHidden('golfer_id',$id);
        $form->addText('course_name');
        $form->setLabel('course_name','Course Name:');
        $form->addText('course_rating');
        $form->setLabel('course_rating','Course Rating:');
        $form->addText('slope');
        $form->setLabel('slope','Slope:');
        $form->addText('score');
        $form->setLabel('score','Score:');
        $form->addText('note');
        $form->setLabel('note','Notes:');
        $form->mergeTemplate($tags);
        $template = PHPWS_Template::process($form->getTemplate(),'golfer','View_Score.tpl');

        Layout::add($template);

        //Pager stuff
        PHPWS_Core::initModClass('golfer','Score.php');
        $pager = new DBPager('golfer_score','Score');
        $pager->setOrder('created_date','desc');
        $pager->setModule('golfer');
        $pager->setTemplate('View_Score_Pager.tpl');
        $pager->addWhere('golfer_id',$id);
        $pager->addToggle('');
        $pager->addToggle(' style="background-color: white"');
        $pager->addRowTags('get_row_tags');
        $pager->addPageTags($tags);

        Layout::add($pager->get());
    }
}
