<?php

class EmailController extends BaseController {

    /**
     *
     */
    public function send() {
        return Email::sendMails();
    }

}