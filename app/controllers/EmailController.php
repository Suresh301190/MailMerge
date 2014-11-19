<?php

class EmailController extends BaseController {

    public function send() {

        return View::make ( 'dashboard.send' );
    
    }

}