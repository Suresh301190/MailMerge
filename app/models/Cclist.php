<?php

/**
 * @property  string email
 * @property string cc_id
 */
class Cclist extends Eloquent
{

    public $timestamps = true;

    public $incrementing = false;

    protected $table = 'cclists';

    protected $primaryKey = 'cc_id';

    public function scopeAddMailCcList()
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

        return DB::table('ccLists')->where('cc_id', '=', Auth::user()->id . '_' . $group)->where('email', '=', $email)->count();

    }

    private function add($group, $email)
    {

        $list = new Cclist ();
        $list->cc_id = Auth::user()->id . '_' . $group;
        $list->email = $email;
        $list->save();

    }

    public function scopeGetAllMails()
    {

        $gname = Input::get('gname');
        $mails = Cclist::findMany(array(
            'cc_id' => Auth::user()->id . '_' . $gname
        ), array(
            'email'
        ))->all('email');

        return Helper::cleanGroups($mails, '|');

    }

    public function scopeDeleteMails()
    {

        $input = Input::all();
        $emailsToDelete = array();
        $data = array();
        foreach ($input as $k => $v) {
            if ($k [0] == '|') {
                $emailsToDelete ["$v"] = $v;
            }
        }

        if (!count($emailsToDelete)) {
            $data ['deleted'] = false;
            return $data;
        }

        $data ['deleted'] = DB::table('cclists')
            ->where('cc_id', '=', Group::getUID() . '_' . $input ['gname'])
            ->whereIn('email', $emailsToDelete)
            ->delete();

        $data ['emailsToDelete'] = $emailsToDelete;
        return $data;

    }

    /**
     * Get Emails corresponding to  group name
     *
     * @param array $groups
     *
     * @return array
     */
    public static function getMails( $groups )
    {
        $mailToFetch = array();
        $gid = Group::getUID();

        foreach ( $groups as $v ) {
            $mailToFetch[ $gid . "_$v" ] = $gid . "_$v";
        }

        $mails = Cclist::findMany( $mailToFetch, array(
            'cc_id',
            'email'
        ) )->toArray();

        return $mails;
    }

}
