<?php
/**
 * Adding a golfer
 * @author Micah Carter <mcarter at tux dot appstate dot edu>
**/

class AddGolferUI {
    public function showAddGolfer($message=NULL) {
        if(!Current_User::allow('golfer','edit_golfer')) {
            PHPWS_Core::initModClass('golfer','GolferHomeUI.php');
            $error = 'You do not have adequate permissions to add golfers.  Ask nicer next time!';
            GolferHomeUI::display($error);
            return;
        }

        $tpl = array();
        $tpl['PAGE_TITLE'] = 'Add a Golfer';
        $tpl['HOME_LINK'] = PHPWS_Text::moduleLink('Back to Golfer Home','golfer');
        if($message) $tpl['MESSAGE'] = $message;
        
        $form = new PHPWS_Form('add_golfer');
        $form->setAction('index.php?module=golfer&action=add_golfer');
        $form->addSubmit('submit','Add');
        $form->addText('golfer_name');
        $form->setLabel('golfer_name','Golfer Name:');
        $form->addText('current_handicap');
        $form->setLabel('current_handicap','Current Handicap (optional):');

        $form->mergeTemplate($tpl);
        $template = PHPWS_Template::process($form->getTemplate(),'golfer','Add_Golfer.tpl');

        Layout::add($template);
    }


}
?>
