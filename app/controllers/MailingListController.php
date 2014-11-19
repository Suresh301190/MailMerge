<?php

/**
 *
 * @author Suresh
 *
 */
class MailingListController extends BaseController {

    public function addNewMail() {

        $input = Input::get ( 'mlist' );
        $data = array ();
        
        if (strcmp ( $input, 'toList' ) == 0) {
            $data = Tolist::addMailToList ();
        }
        else if (strcmp ( $input, 'ccList' ) == 0) {
            $data = Cclist::addMailCcList ();
        }
        else if (strcmp ( $input, 'bccList' ) == 0) {
            $data = Bcclist::addMailBccList ();
        }
        
        return View::make ( 'dashboard.lists', array (
                'groups' => Group::getAllGroups (),
                'mlists' => Helper::getMailingListArray (),
                'data' => $data
        ) );
    
    }

    public function getMails() {

        $input = Input::get ( 'mlist' );
        $data = array ();
        
        if (strcmp ( $input, 'toList' ) == 0) {
            $data = Tolist::getAllMails ();
        }
        else if (strcmp ( $input, 'ccList' ) == 0) {
            $data = Cclist::getAllMails ();
        }
        else if (strcmp ( $input, 'bccList' ) == 0) {
            $data = Bcclist::getAllMails ();
        }
        
        return View::make ( 'dashboard.delete', array (
                'groups' => Group::getAllGroups (),
                'mlists' => Helper::getMailingListArray (),
                'toDelete' => $data
        ) );
    
    }

    public function deleteMails() {

        $input = Input::get ( 'mlist' );
        $data = array ();
        
        if (strcmp ( $input, 'toList' ) == 0) {
            $data = Tolist::deleteMails ();
        }
        else if (strcmp ( $input, 'ccList' ) == 0) {
            $data = Cclist::deleteMails ();
        }
        else if (strcmp ( $input, 'bccList' ) == 0) {
            $data = Bcclist::deleteMails ();
        }
        
        return View::make ( 'dashboard.lists', array (
                'groups' => Group::getAllGroups (),
                'mlists' => Helper::getMailingListArray (),
                'data' => $data
        ) );
    
    }

}