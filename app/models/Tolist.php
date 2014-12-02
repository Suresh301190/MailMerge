<?php

class Tolist extends Eloquent
{

    public $timestamps = true;

    public $incrementing = false;

    protected $table = 'tolists';

    protected $primaryKey = 'to_id';

    /**
     * Adds the email address to the ToList database if doesn't exists
     * @return array
     */
    public function scopeAddMailToList()
    {

        $data = array();
        $data ['gname'] = Input::get('gname');
        $data ['email'] = Input::get('email');
        $data ['empty'] = $data ['gname'] === "" || $data ['email'] === "";
        if ($data ['empty'] || self::mailExists($data ['gname'], $data ['email'])) {
            $data ['added'] = false;
        } else {
            self::add($data ['gname'], $data ['email']);
            $data ['added'] = true;
        }

        return $data;

    }

    private function mailExists($group, $email)
    {

        return DB::table('toLists')->where('to_id', '=', Auth::user()->id . '_' . $group)->where('email', '=', $email)->count();

    }

    private function add($group, $email)
    {

        $list = new Tolist ();
        $list->to_id = Auth::user()->id . '_' . $group;
        $list->email = $email;
        $list->save();

    }

    public function scopeGetAllMails()
    {

        $gname = Input::get('gname');

        $mails = Tolist::findMany(array(
            'to_id' => Auth::user()->id . '_' . $gname
        ), array(
            'email'
        ))->all('email');

        return Helper::cleanGroups($mails, '|');

    }

    /**
     * To delete the mails from the database
     * @return array $data[ array => 'emailsToDelete', 'deleted']
     */
    public function scopeDeleteMails()
    {

        $input = Input::all();
        $emailsToDelete = array();
        $data = array();

        //TO clean the input received from
        foreach ($input as $k => $v) {
            if ($k [0] == '|') {
                $emailsToDelete ["$v"] = $v;
            }
        }

        if (!count($emailsToDelete)) {
            $data ['deleted'] = false;
            return $data;
        }

        $data ['deleted'] = DB::table('tolists')->where('to_id', '=', Group::getUID() . '_' . $input ['gname'])->whereIn('email', $emailsToDelete)->delete();
        $data ['emailsToDelete'] = $emailsToDelete;

        return $data;

    }

    public static function getMails($groups)
    {
        $mailToFetch = array();
        $gid = Group::getUID();

        foreach ($groups as $k => $v) {
            $mailToFetch["$gid_$v"] = "$gid_$v";
        }

        return Tolist::findMany($mailToFetch)->groupBy('to_id')->attributesToArray();
    }

}
