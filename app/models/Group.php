<?php
use Illuminate\Auth\UserInterface;

class Group extends Eloquent {

    public $timestamps = true;

    public $incrementing = false;

    protected $table = 'groups';

    protected $primaryKey = 'gid';

    public function scopeAddGroup() {

        $data = array ();
        $data ['gname'] = str_replace ( ' ', '_', strtolower ( Input::get ( 'gname' ) ) );
        $data ['hr_name'] = Input::get ( 'hr_name' );
        $data ['company'] = Input::get ( 'company' );
        
        if (self::groupExists ( $data ['gname'] )) {
            $data ['added'] = false;
        }
        else {
            self::add ( $data );
            $data ['added'] = true;
        }
        
        return $data;
    
    }

    public function scopeGetInstance() {

        return $this;
    
    }

    private static function groupExists($group) {

        return DB::table ( 'groups' )->where ( 'gid', '=', Auth::user ()->id )->where ( 'gname', '=', $group )->count ();
    
    }

    private function add($data) {

        $newGroup = new Group ();
        $newGroup->gid = Auth::user ()->id;
        $newGroup->gname = $data['gname'];
        $newGroup->gid_name = Auth::user ()->id . '_' . $data['gname'];
        $newGroup->hr_name = $data['hr_name'];
        $newGroup->company = $data['company'];
        $newGroup->save ();
        
        Cache::forever ( 'isGroupUpdated', true );
    
    }

    public function scopeGetAllGroups() {

        /*
         * if ( Cache::has ( 'isGroupUpdated' )) {
         * $groups = Group::findMany ( array (
         * 'gid' => Auth::user ()->id
         * ), array (
         * 'gname'
         * ) )->all ( 'gname' );
         *
         * Cache::forget( Auth::user ()->id . '_Groups' );
         * Cache::add ( Auth::user ()->id . '_Groups', Helper::cleanGroups($groups), 20 );
         * Cache::forget ( 'isGroupUpdated' );
         * }
         *
         * return Cache::get ( Auth::user ()->id . '_Groups' );
         *
         */
        $groups = Group::findMany ( array (
                'gid' => Auth::user ()->id
        ), array (
                'gname'
        ) )->all ( 'gname' );
        
        return Helper::cleanGroups ( $groups );
    
    }

    public function scopeDeleteOne() {

        $data = array ();
        $data ['gname'] = strtolower ( Input::get ( 'gname' ) );
        
        $data ['deleted'] = DB::table ( 'groups' )->where ( 'gid_name', '=', Auth::user ()->id . "_" . $data ['gname'] )->delete () ? true : false;
        
        Cache::forever ( 'isGroupUpdated', true );
        
        return $data;
    
    }

    public function scopeUpdateGroupName() {

        $data = array ();
        $data ['gname'] = strtolower ( Input::get ( 'gname' ) );
        $data ['toUpdate'] = str_replace ( ' ', '_', strtolower ( Input::get ( 'toUpdate' ) ) );
        $toUpdate = DB::table ( 'groups' )->where ( 'gid_name', '=', Auth::user ()->id . '_' . $data ['gname'] )->update ( array (
                'gname' => $data ['toUpdate'],
                'gid_name' => Auth::user ()->id . '_' . $data ['toUpdate']
        ) );
        
        $data ['updated'] = true;
        
        return $data;
    
    }

}