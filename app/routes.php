<?php

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the Closure to execute when that URI is requested.
 * |
 */
Route::get ( '/', function () {
    return View::make ( 'hello' );
} );

/*
 * Route::get('home', function()
 * {
 * return View::make('dashboard.home');
 * });
 * //
 */

Route::group ( array (
        'before' => array (
                'google-finish-authentication',
                'auth'
        )
), function () {
    Route::get ( 'home', 'HomeController@showWelcome' );
} );

Route::get ( 'login', function () {
    return View::make ( 'dashboard.login', array (
            'authUrl' => Auth::getAuthUrl ()
    ) );
} );

Route::get ( 'logout', function () {
    Auth::logout ();
    return Redirect::to ( 'login' );
} );

Route::get ( 'users', function () {
    $users = User::all ();
    
    return View::make ( 'users' )->with ( 'users', $users );
} );

Route::get ( 'groups', function () {
    if (Auth::check ()) {
        return View::make ( 'dashboard.groups', array (
                'groups' => Group::getAllGroups ()
        ) );
    }
    return Redirect::to ( 'login' );
} );

Route::get ( 'lists', function () {
    if (Auth::check ()) {
        return View::make ( 'dashboard.lists', array (
                'groups' => Group::getAllGroups (),
                'mlists' => Email::getMailingListArray ()
        ) );
    }
    return Redirect::to ( 'login' );
} );

Route::get ( 'send', function () {
    if (Auth::check ()) {
        return View::make ( 'dashboard.send', array (
                'groups' => Group::getAllGroups (),
                'content' => Email::getSendUseage()
        ) );
    }
    return Redirect::to ( 'login' );
} );

Route::get ( 'profile', function () {
    if (Auth::check ()) {
        return View::make ( 'dashboard.profile' );
    }
    return Redirect::to ( 'login' );
} );

Route::get ( 'managetemplate', function () {
    if (Auth::check ()) {
        return View::make ( 'dashboard.managetemplate', array (
                'content' => Email::getModifyUseage ()
        ) );
    }
    return Redirect::to ( 'login' );
} );

Route::post ( 'deleteGroup', 'GroupController@deleteGroup' );

Route::post ( 'addNewGroup', 'GroupController@addNewGroup' );

Route::post ( 'updateGroup', 'GroupController@updateGroup' );

Route::post ( 'AddToMailingList', 'MailingListController@addNewMail' );

Route::post ( 'getMailsToDelete', 'MailingListController@getMails' );

Route::post ( 'deleteMails', 'MailingListController@deleteMails' );

Route::post ( 'sendMail', 'EmailController@send' );

Route::post ( 'getContent', function () {
    // var_dump(Input::get('template_type'));
    
    if (Input::get ( 'template-modify', 0 ) == 0) {
        return View::make ( 'dashboard.send', array (
                'content' => Email::getTemplateContent ( Input::get ( 'TID' ) )
        ) );
    }
    else {
        return View::make ( 'dashboard.managetemplate', array (
                'content' => Email::getTemplateContent ( Input::get ( 'TID' ) )
        ) );
    }
} );

Route::post ( 'saveTemplate', function () {
    
    $data = Email::putTemplateContents ( Input::get ( 'TID' ), Input::get ( 'content' ) );
    
    return View::make ( 'dashboard.manageTemplate', array (
            'content' => $data ['content'],
            'success' => $data ['success'],
            'type' => $data ['type']
    ) );
} );
