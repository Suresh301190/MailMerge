<?php

/**
 *
 * @author Suresh
 *
 */
class MailingListController extends BaseController {

    public function addNewMail() {

        $input = Input::get ('mlist');
        $data = array();
        
        if (strcmp ( $input, 'toList' ) == 0) {
            $data = Tolist::addMailToList($input);
        }
        else if (strcmp ( $input, 'ccList' ) == 0) {
            $data = Cclist::addMailCcList($input);
        }
        else if (strcmp ( $input, 'bccList' ) == 0) {
            $data = Bcclist::addMailBccList($input);
        }
        
        return View::make ( 'dashboard.lists', array (
                'groups' => Group::getAllGroups (),
                'mlists' => Helper::getMailingListArray (),
                'data' => $data
        ) );
    
    }

}