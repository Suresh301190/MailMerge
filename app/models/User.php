<?php
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
    
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
    protected $hidden = array (
            'password',
            'remember_token'
    );

    public function scopeAddUser() {

        $data = array ();
        if (!self::userExists()) {
            $data ['added'] = false;
        }
        else {
            self::add ();
            $data ['added'] = true;
        }
        return $data;
    
    }

    private static function add() {

        $user = new User ();
        $user->id = Auth::user ()->id;
        $user->name = Auth::user ()->name;
        $user->email = Auth::user ()->email;
        $user->save ();
    
    }
    
    public static function userExists(){
        return count(self::getRow());
    }
    
    private static function getRow() {
        return  DB::select ( 'select * from users where id = \'?\'', array (
                Auth::user()->id
        ) );
    }

}
