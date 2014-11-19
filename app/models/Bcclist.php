<?php

class Bcclist extends Eloquent {

    public $timestamps = true;

    public $incrementing = false;

    protected $table = 'bcclists';

    protected $primaryKey = 'bcc_id';

    public function scopeAddMailBccList() {

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

        return DB::table ( 'bccLists' )->where ( 'bcc_id', '=', Auth::user ()->id . '_' . $group )->where ( 'email', '=', $email )->count ();
    
    }

    private function add($group, $email) {

        $list = new Bcclist ();
        $list->bcc_id = Auth::user ()->id . '_' . $group;
        $list->email = $email;
        $list->save ();
    
    }

}
