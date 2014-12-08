<?php
    use Carbon\Carbon;

    /**
     * @property string   gid
     * @property string   gname
     * @property string   gid_name
     * @property string   hr_name
     * @property string   state
     * @property string   company
     * @property datetime reminder
     */
    class Group extends Eloquent
    {

        public $timestamps = true;

        public $incrementing = false;

        protected $table = 'groups';

        protected $primaryKey = 'gid';

        /**
         * Contains the states of mail
         *
         * @var array
         */
        private static $states = array(
            'invite',
            'follow',
            'confirm',
        );

        public static function getStatesArray()
        {
            return self::$states;
        }

        /**
         * To store the next state transition for the state property
         *
         * @var array
         */
        private static $nextState = array(
            'invite'  => 'follow',
            'follow'  => 'confirm',
            'confirm' => 'confirmed',
        );

        public static function getNextState( $state )
        {
            if ( is_null( self::$nextState["$state"] ) )
                return null;

            return self::$nextState["$state"];
        }

        /**
         * To add group if doesn't exists already Receives the data from HTTP POST
         *
         * @gname   group name
         * @hr_name HR person Name
         * @company Company name
         *
         * @return array $data['gname', 'hr_name', 'company', 'empty', 'added']
         */
        public function scopeAddGroup()
        {

            $data = array();
            $data ['gname'] = str_replace( ' ', '_', strtolower( Input::get( 'gname' ) ) );
            $data ['hr_name'] = Input::get( 'hr_name' );
            $data ['company'] = Input::get( 'company' );

            $data ['empty'] = $data ['gname'] === "" || $data ['hr_name'] === "" || $data ['company'] === "";

            if ( $data ['empty'] || self::groupExists( $data ['gname'] ) ) {
                $data ['added'] = false;
            } else {
                self::add( $data );
                $data ['added'] = true;
            }

            return $data;
        }

        /**
         * @return $this
         */
        public function scopeGetInstance()
        {
            return $this;
        }

        /**
         * @param string $group to search for
         *
         * @return int no. of occurrences
         */
        private static function groupExists( $group )
        {
            return DB::table( 'groups' )->where( 'gid', '=', self::getUID() )->where( 'gname', '=', $group )->count();
        }

        /**
         * To add a new Group
         *
         * @param array $data
         */
        private function add( $data )
        {

            $newGroup = new Group ();
            $newGroup->gid = self::getUID();
            $newGroup->gname = $data ['gname'];
            $newGroup->gid_name = self::getUID() . '_' . $data ['gname'];
            $newGroup->hr_name = $data ['hr_name'];
            $newGroup->company = $data ['company'];
            $newGroup->state = self::$states [0];

            $newGroup->save();

            self::setGroupUpdated();

        }

        /**
         * Factory function to get all the groups under a user,
         * <br>further it caches the results for better performance
         *
         * @return mixed
         */
        public function scopeGetAllGroups()
        {
            if ( Cache::has( Group::getGroupsString() ) )
                return Cache::get( Group::getGroupsString() );

            $groups = Group::select( array( 'gname' ) )
                ->where( 'gid', '=', User::getUID() )
                ->get()->toArray();

            $groupKeyValue = Helper::makeKeyValuePair( $groups );
            Cache::put( Group::getGroupsString(), $groupKeyValue, 30 );

            return $groupKeyValue;
        }

        /**
         * To delete a group if exists Data is received via HTTP POST
         * <br>@gname group name
         *
         * @return array $data['gname', 'deleted']
         */
        public function scopeDeleteOne()
        {

            $data = array();
            $data ['gname'] = strtolower( Input::get( 'gname' ) );

            $data ['deleted'] = DB::table( 'groups' )->where( 'gid_name', '=', self::getUID() . "_" . $data ['gname'] )->delete() ? true : false;

            self::setGroupUpdated();

            return $data;

        }

        /**
         * To update a group name if exists data is received via
         * HTTP POST <br>@gname group name
         * <br> @toUpdate updateTo
         *
         * @return array $data['gname', 'toUpdate', 'empty', 'updated']
         */
        public function scopeUpdateGroupName()
        {

            $data = array();
            $data ['gname'] = strtolower( Input::get( 'gname' ) );
            $data ['toUpdate'] = str_replace( ' ', '_', strtolower( Input::get( 'toUpdate' ) ) );
            $data ['empty'] = $data ['toUpdate'] === "";

            if ( $data ['empty'] )
                return $data;

            DB::table( 'groups' )
                ->where( 'gid_name', '=', self::getUID() . '_' . $data ['gname'] )
                ->update( array(
                    'gname'    => $data ['toUpdate'],
                    'gid_name' => self::getUID() . '_' . $data ['toUpdate']
                ) );

            $data ['updated'] = true;
            self::setGroupUpdated();

            return $data;

        }

        /**
         * To remove the Cache entry for all groups under a User
         */
        private static function setGroupUpdated()
        {

            Cache::forget( Group::getGroupsString() );
            Cache::forget( Group::getGroupByStatusString() );

        }

        /**
         * @return string $id Google ID of the user
         */
        public static function getUID()
        {

            return Auth::user()->id;

        }

        /**
         * To get the groups grouped by $status
         *
         * @return array
         */
        public static function getAllGroupsByStatus()
        {
            if ( Cache::has( Group::getGroupByStatusString() ) )
                return Cache::get( Group::getGroupByStatusString() );

            $groupsBystatus = array();

            foreach ( self::$states as $v ) {
                $groups = Group::select( array( 'gname' ) )
                    ->where( 'gid', '=', Group::getUID() )
                    ->where( 'state', '=', "$v" )
                    ->get()
                    ->toArray();
                $groupsBystatus ["$v"] = Helper::makeKeyValuePair( $groups );
            }

            Cache::put( Group::getGroupByStatusString(), $groupsBystatus, 30 );

            return $groupsBystatus;
        }

        public static function getAllGroupsByStatusCount()
        {
            $groupsByStatus = Group::getAllGroupsByStatus();

            $count = array();
            foreach ( $groupsByStatus as $k => $v ) {
                $count["$k"] = count( $v );
            }

            return $count;
        }

        private static $replace = array(
            'hr_name', 'company'
        );

        public static function getReplaceValues( $group )
        {
            return Group::select( self::$replace )
                ->where( 'gid', '=', Group::getUID() )
                ->where( 'gname', '=', $group )
                ->get()
                ->toArray();
        }

        private static function getGroupsString()
        {
            return User::getUID() . '_Groups';
        }

        private static function getGroupByStatusString()
        {
            return User::getUID() . '_GroupByStatus';
        }

        /**
         * Update the state of the group
         *
         * @param string $uid
         * @param string $group
         * @param enum   $state  current state
         * @param int    $remind Remind after x days
         */
        public static function updateState( $uid, $group, $state, $remind )
        {
            $next = self::getNextState( $state );

            Log::info( "@Suresh-- $state --> $next" );
            if ( null == $next )
                return;

            DB::table( 'groups' )
                ->where( 'gid', '=', $uid )
                ->where( 'gname', '=', $group )
                ->update( array(
                    'state'    => $next,
                    'reminder' => Carbon::now()->addDays( $remind ),
                ) );

            self::setGroupUpdated();

        }

    }