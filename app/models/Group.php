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
        
        if (self::groupExists ( $data ['gname'] )) {
            $data ['added'] = false;
        }
        else {
            self::add ( $data ['gname'] );
            $data ['added'] = true;
        }
        
        return $data;
    
    }

    public function scopeGetInstance() {

        return $this;
    
    }

    private static function groupExists($group) {

        return DB::table ( 'groups' )->where ( 'gid', '=', Auth::user ()->id )->where ( 'group_name', '=', $group )->count ();
    
    }

    private function add($group) {

        $id = Auth::user ()->id;
        DB::table ( 'groups' )->insert ( array (
                'gid' => Auth::user ()->id,
                'group_name' => $group,
                'gid_name' => Auth::user ()->id . "_" . $group
        ) );
        
        Cache::forever ( 'isGroupUpdated', true );
    
    }

    public function scopeGetAllGroups() {

        /*
         * if ( Cache::has ( 'isGroupUpdated' )) {
         * $groups = Group::findMany ( array (
         * 'gid' => Auth::user ()->id
         * ), array (
         * 'group_name'
         * ) )->all ( 'group_name' );
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
                'group_name'
        ) )->all ( 'group_name' );
        
        return Helper::cleanGroups ( $groups );
    
    }

    public function scopeDeleteOne() {

        $data = array ();
        $data ['gname'] = strtolower ( Input::get ( 'gname' ) );
        
        $data ['deleted'] = DB::table ( 'groups' )->where ( 'gid_name', '=', Auth::user ()->id . "_" . $data ['gname'] )->delete () ? true : false;
        
        Cache::forever ( 'isGroupUpdated', true );
        
        return $data;
    
    }

}