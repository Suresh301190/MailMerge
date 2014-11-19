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
                'mlists' => Helper::getMailingListArray()
        ) );
    }
    return Redirect::to ( 'login' );
} );

Route::get ( 'send', function () {
    if (Auth::check ()) {
        return View::make ( 'dashboard.send', array (
                'groups' => Group::getAllGroups ()
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

Route::post ( 'deleteGroup', 'GroupController@deleteGroup' );

Route::post ( 'addNewGroup', 'GroupController@addNewGroup' );

Route::post ( 'updateGroup', 'GroupController@updateGroup' );

Route::post('AddToMailingList', 'MailingListController@addNewMail');

Route::post('getMailsToDelete', 'MailingListController@getMails');

Route::post('deleteMails', 'MailingListController@deleteMails');

Route::post('sendMail', 'EmailController@send');

