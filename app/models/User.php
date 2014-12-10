<?php
    use Illuminate\Auth\Reminders\RemindableInterface;
    use Illuminate\Auth\Reminders\RemindableTrait;
    use Illuminate\Auth\UserInterface;
    use Illuminate\Auth\UserTrait;

    /**
     * @property string  name
     * @property string  email
     * @property string  id
     */
    class User extends Eloquent implements UserInterface, RemindableInterface
    {

        use UserTrait, RemindableTrait;
        public $timestamps = true;
        public $incrementing = false;

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'users';

        /**
         * The attributes excluded from the model's JSON form.
         *
         * @var array
         */
        protected $hidden = array(
            'password',
            'remember_token'
        );

        /**
         * To add a new User if not registered
         * @return array $data['added']
         */
        public function scopeAddUser()
        {

            $data = array();
            if ( self::userExists() ) {
                $data ['added'] = false;
            } else {
                self::add();
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
         * Adds a new user using the session variables of google Auth 2.0
         */
        private static function add()
        {

            $user = new User ();
            $user->id = Auth::user()->id;
            $user->name = Auth::user()->name;
            $user->email = Auth::user()->email;
            $user->save();

        }

        /**
         * checks if user exists in the table
         *
         * @return bool true if users is already registered
         */
        public static function userExists()
        {
            return DB::table( 'users' )->where( 'id', '=', Auth::user()->id )->exists();
        }

        /**
         * @return mixed|static user entry if exists
         */
        private static function getRow()
        {

            return DB::table( 'users' )->where( 'id', '=', Auth::user()->id )->first();

        }

        /**
         * @return string $id Google ID of the user
         */
        public static function getUID()
        {

            return Auth::user()->id;

        }

    }
