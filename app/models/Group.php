<?php
use Illuminate\Auth\UserInterface;

class Group extends Eloquent {

    public $timestamps = true;

    public $incrementing = false;

    protected $table = 'groups';

    protected $primaryKey = 'gid';

    /**
     * To add group if doesn't exists already Receives the data from HTTP POST
     * @gname group name
     * @hr_name HR person Name
     * @company Company name
     * @return multitype:boolean mixed
     */
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

        return DB::table ( 'groups' )->where ( 'gid', '=', self::getUID() )->where ( 'gname', '=', $group )->count ();
    
    }

    /**
     * To add a new Group
     *
     * @param array $data
     */
    private function add($data) {

        $newGroup = new Group ();
        $newGroup->gid = self::getUID();
        $newGroup->gname = $data ['gname'];
        $newGroup->gid_name = self::getUID() . '_' . $data ['gname'];
        $newGroup->hr_name = $data ['hr_name'];
        $newGroup->company = $data ['company'];
        $newGroup->save ();
        
        self::setGroupUpdated ();
    
    }

    /**
     * Factory function to get all the groups under a user,
     * <br>further it caches the results for better performance
     *
     * @return mixed
     */
    public function scopeGetAllGroups() {

        if (! Cache::has ( self::getUID() . '_isGroupUpdated' )) {
            $groups = Group::findMany ( array (
                    'gid' => self::getUID()
            ), array (
                    'gname'
            ) )->all ( 'gname' );
            
            self::setGroupUpdated ();
            Cache::forever ( self::getUID() . '_isGroupUpdated', Helper::cleanGroups ( $groups ) );
        }
        
        return Cache::get ( self::getUID() . '_isGroupUpdated' );
     // Helper::cleanGroups ( $groups );
    }

    /**
     * To delete a group if exists Data is received via HTTP POST
     * <br>@gname group name
     *
     * @return multitype:boolean string
     */
    public function scopeDeleteOne() {

        $data = array ();
        $data ['gname'] = strtolower ( Input::get ( 'gname' ) );
        
        $data ['deleted'] = DB::table ( 'groups' )->where ( 'gid_name', '=', self::getUID() . "_" . $data ['gname'] )->delete () ? true : false;
        
        self::setGroupUpdated ();
        
        return $data;
    
    }

    /**
     * To update a group name if exists data is received via
     * HTTP POST <br>@gname group name
     * <br> @toUpdate updateTo
     *
     * @return multitype:boolean string NULL
     */
    public function scopeUpdateGroupName() {

        $data = array ();
        $data ['gname'] = strtolower ( Input::get ( 'gname' ) );
        $data ['toUpdate'] = str_replace ( ' ', '_', strtolower ( Input::get ( 'toUpdate' ) ) );
        $toUpdate = DB::table ( 'groups' )->where ( 'gid_name', '=', self::getUID() . '_' . $data ['gname'] )->update ( array (
                'gname' => $data ['toUpdate'],
                'gid_name' => self::getUID() . '_' . $data ['toUpdate']
        ) );
        
        $data ['updated'] = true;
        self::setGroupUpdated ();
        
        return $data;
    
    }

    /**
     * To remove the Cache entry for all groups under a User
     */
    private static function setGroupUpdated() {

        Cache::forget ( self::getUID() . '_isGroupUpdated' );
    
    }

    private static function getUID() {

        return Auth::user ()->id;
    
    }

}