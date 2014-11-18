<?php

/**
 * Class to handle all calls to the Manage Groups for a user
 * @author Suresh
 *
 */
class GroupController extends BaseController {

    public function addNewGroup() {

        return View::make ( 'dashboard.groups', array (
                'data' => Group::addGroup (),
                'groups' => Group::getAllGroups()
        ) );
    
    }

    public function getGroups() {

        return View::make ( 'dashboard.groups', array (
                'groups' => Group::getAllGroups ()
        ) );
    
    }

    public function deleteGroup() {

        return View::make ( 'dashboard.groups', array (
                'data' => Group::deleteOne (),
                'groups' => Group::getAllGroups()
        ) );
    
    }

}