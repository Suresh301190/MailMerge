<?php
    use Illuminate\Auth\Reminders\RemindableInterface;
    use Illuminate\Auth\Reminders\RemindableTrait;
    use Illuminate\Auth\UserInterface;
    use Illuminate\Auth\UserTrait;

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

    public function scopeAddUser()
    {

        $data = array();
        if (self::userExists()) {
            $data ['added'] = false;
        } else {
            self::add();
            $data ['added'] = true;
        }
        return $data;

    }

    public function scopeGetInstance()
    {

        return $this;

    }

    private static function add()
    {

        $user = new User ();
        $user->id = Auth::user()->id;
        $user->name = Auth::user()->name;
        $user->email = Auth::user()->email;
        $user->save();

    }

    public static function userExists()
    {

        return DB::table('users')->where('id', '=', Auth::user()->id)->count();

    }

    private static function getRow()
    {

        return DB::table('users')->where('id', '=', Auth::user()->id)->first();

    }

}
