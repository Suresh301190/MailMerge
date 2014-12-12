<?php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Log;

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

        /**
         * Get the array of states available
         *
         * @param bool $confirmed add confirmed as well to states
         *
         * @return array
         */
        public static function getStatesArray( $confirmed = false )
        {
            if ( $confirmed )
                return array_merge( self::$states, array( 'confirmed' ) );

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
                $data ['success'] = false;
                $data['message'] = 'Group Name: ' . $data['gname'] . ' Already Exists';
            } else {
                self::add( $data );
                $data ['success'] = true;
                $data['message'] = 'Group Name: ' . $data['gname'] . ' Added Successfully';
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
         * <br>Temporarily Caching is disabled
         *
         * @return mixed
         */
        public function scopeGetAllGroups()
        {
            //if ( Cache::has( Group::getGroupsString() ) )
            //    return Cache::get( Group::getGroupsString() );

            $groups = Group::select( array( 'gname' ) )
                ->where( 'gid', '=', User::getUID() )
                ->get()->toArray();

            $groupKeyValue = Helper::makeKeyValuePair( $groups );

            //Cache::put( Group::getGroupsString(), $groupKeyValue, 30 );

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
            $ret = array();
            $ret['message'] = 'Stop playing with the system';
            $data = all();

            if ( !isset( $data['gname'] ) ) {
                $ret['success'] = false;

                return $ret;
            }

            $ret ['success'] = DB::table( 'groups' )
                ->where( 'gid_name', '=', self::getUID() . "_" . $data ['gname'] )
                ->delete() ? true : false;

            self::setGroupUpdated();
            $ret['message'] = "Group " . $data['gname'] . ' Deleted Successfully';

            return $ret;

        }

        /**
         * To update a group name if exists data is received via
         * HTTP POST <br>@gname group name
         * <br> @toUpdate updateTo
         *
         * @return array $data['gname', 'toUpdate', 'empty', 'updated']
         */
        public function scopeUpdateGroupDetails()
        {

            $data = Input::all();
            $toUpdate = array();

            // if new group name is given
            if ( !empty( $data['ugname'] ) ) {
                $toUpdate['gname'] = str_replace( ' ', '_', strtolower( Input::get( 'ugname' ) ) );
                $toUpdate['gid_name'] = User::getUID() . '_' . $toUpdate['gname'];
            }
            // if new HR name is given
            if ( !empty( $data['HR'] ) ) {
                $toUpdate['hr_name'] = $data['HR'];
            }
            // if new Company name is given
            if ( !empty( $data['COMPANY'] ) ) {
                $toUpdate['company'] = $data['COMPANY'];
            }

            if ( strcmp( $data['state'], 'default' ) && in_array( $data['state'], self::$states ) ) {
                $toUpdate['state'] = $data['state'];
            }
            Log::info( $data['state'] );

            if ( !count( $toUpdate ) ) {
                $toUpdate['message'] = 'Invalid Values please try again';
                $toUpdate['success'] = false;

                return $toUpdate;
            }

            $toUpdate['updated_at'] = Carbon::now()->toDateTimeString();

            DB::table( 'groups' )
                ->where( 'gid_name', '=', self::getUID() . '_' . $data ['gname'] )
                ->update( $toUpdate );

            $toUpdate['message'] = "All values updated Successfully";
            $toUpdate ['success'] = true;
            self::setGroupUpdated();

            return $toUpdate;

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
            //if ( Cache::has( Group::getGroupByStatusString() ) )
            //    return Cache::get( Group::getGroupByStatusString() );

            $groupsBystatus = array();

            foreach ( self::$states as $v ) {
                $groups = Group::select( array( 'gname' ) )
                    ->where( 'gid', '=', Group::getUID() )
                    ->where( 'state', '=', "$v" )
                    ->get()
                    ->toArray();
                $groupsBystatus ["$v"] = Helper::makeKeyValuePair( $groups );
            }

            //Cache::put( Group::getGroupByStatusString(), $groupsBystatus, 30 );

            return $groupsBystatus;
        }

        public static function getAllGroupsByStatusCount( $confirm = false )
        {
            $groupsByStatus = Group::getAllGroupsByStatus();

            if ( $confirm )
                $groupsByStatus = array_merge( $groupsByStatus, array( 'confirmed' => 'confirmed' ) );

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

            //Log::info( "@Suresh-- $state --> $next" );
            if ( null == $next )
                return;

            DB::table( 'groups' )
                ->where( 'gid', '=', $uid )
                ->where( 'gname', '=', $group )
                ->update( array(
                    'state'      => $next,
                    'reminder'   => Carbon::now()->addDays( $remind ),
                    'updated_at' => Carbon::now(),
                ) );

            // to clear cache
            self::setGroupUpdated();

        }

        /**
         * Get a list of reminders for the user
         *
         * @return array $reminders
         */
        public static function getReminders()
        {
            $reminders = Group::select( array( 'gname', 'state' ) )
                ->where( 'gid', '=', User::getUID() )
                ->where( 'state', '!=', 'confirmed' )
                ->where( 'updated_at', '<=', Carbon::now()->toDateTimeString() )
                ->orderBy( 'reminder' )
                ->get()
                ->toArray();

            return $reminders;
        }

        /**
         * counts the no. of reminders available for the user
         *
         * @return int
         */
        public static function getReminderCount()
        {
            return count( Group::getReminders() );
        }

    }