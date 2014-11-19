<?php

class Tolist extends Eloquent {

    public $timestamps = true;

    public $incrementing = false;

    protected $table = 'tolists';

    protected $primaryKey = 'to_id';

    public function scopeAddMailToList() {

        $data = array ();
        $data ['gname'] = Input::get ( 'gname' );
        $data ['email'] = Input::get ( 'email' );
        
        if (self::mailExists ( $data ['gname'], $data ['email'] )) {
            $data ['added'] = false;
        }
        else {
            self::add ( $data ['gname'], $data ['email'] );
            $data ['added'] = true;
        }
        
        return $data;
    
    }

    private function mailExists($group, $email) {

        return DB::table ( 'toLists' )->where ( 'to_id', '=', Auth::user ()->id . '_' . $group )->where ( 'email', '=', $email )->count ();
    
    }

    private function add($group, $email) {

        $list = new Tolist ();
        $list->to_id = Auth::user ()->id . '_' . $group;
        $list->email = $email;
        $list->save ();
    
    }
    
    public function scopeGetAllMails() {
    
        $gname = Input::get ( 'gname' );
    
        $mails = Tolist::findMany ( array (
                'to_id' => Auth::user ()->id . '_' . $gname
        ) )->all ( array (
                'email'
        ) );
    
        return $mails;
    
    }

}
