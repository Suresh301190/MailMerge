<?php

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
            
    }

}
?>