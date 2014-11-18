<?php
use Illuminate\Auth\UserInterface;

class Group extends Eloquent {

    public $timestamps = true;

    public $incrementing = false;

    protected $table = 'groups';

    public function scopeAddGroup() {

        $data = array ();
        $data ['gname'] = strtolower ( Input::get ( 'gname' ) );
        
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
    
    }

    public function scopeGetAllGroups() {

        return array (
                //'groups' => DB::table ( 'groups' )->select ( 'group_name' )->where ( 'gid', '=', Auth::user ()->id );
                'group' => Group::select('group_name')->
        );
    
    }

    public function scopeDeleteOne() {

        $data = array ();
        $data ['gname'] = strtolower ( Input::get ( 'gname' ) );
        
        $data ['deleted'] = DB::table ( 'groups' )->where ( 'gid_name', '=', Auth::user ()->id . "_" . $data ['gname'] )->delete ()?true:false;
        
        return $data;
    
    }

}