<?php

    use Illuminate\Support\Facades\Input;
    use Illuminate\Support\Facades\View;

    class Email {

    const HTML_HEADER = '<!DOCTYPE html>
        <html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>';

    const HTML_FOOTER = '</body></html>';

    private static $mailingLists = array (
            'toList' => 'to-List',
            'ccList' => 'cc-List',
            'bccList' => 'bcc-List'
    );

    public static final function getMailingListArray() {

        return self::$mailingLists;

    }

    public static function sendMails() {
        $data = Input::all();

        foreach(Group::getStatesArray() as $states){
            $data["$states"] = Tolist::getMails(isset($data["$states"])?$data["$states"]:array());
        }

        $data['groupsByStatus'] = Group::getAllGroupsByStatus();
        $data['data'] = array_merge(Input::all(), $data);
        return View::make('dashboard.send', $data);
    }

}
?>