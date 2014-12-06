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
    use Illuminate\Support\Facades\Input;

    Route::get( '/', function () {
        return View::make( 'hello' );
    } );

    /*
     * Route::get('home', function()
     * {
     * return View::make('dashboard.home');
     * });
     * //
     */

    Route::group( array(
        'before' => array(
            'google-finish-authentication',
            'auth'
        )
    ), function () {
        Route::get( 'home', 'HomeController@showWelcome' );
    } );

    Route::get( 'login', function () {
        return View::make( 'dashboard.login', array(
            'authUrl' => Auth::getAuthUrl()
        ) );
    } );

    Route::get( 'logout', function () {
        Auth::logout();

        return Redirect::to( 'login' );
    } );

    Route::get( 'users', function () {
        $users = User::all();

        return View::make( 'users' )->with( 'users', $users );
    } );

    Route::get( 'groups', function () {
        if ( !Auth::check() ) {
            return Redirect::to( 'login' );
        }

        return View::make( 'dashboard.groups', array(
            'groups' => Group::getAllGroups()
        ) );
    } );

    Route::get( 'lists', function () {
        if ( !Auth::check() ) {
            return Redirect::to( 'login' );
        }

        return View::make( 'dashboard.lists', array(
            'groups' => Group::getAllGroups(),
            'mlists' => Email::getMailingListArray()
        ) );


        return Redirect::to( 'login' );
    } );

    Route::get( 'send', function () {
        if ( !Auth::check() ) {
            return Redirect::to( 'login' );
        }

        return View::make( 'dashboard.send', array(
            'groups'         => Group::getAllGroups(),
            'content'        => Template::getSendUsage(),
            'groupsByStatus' => Group::getAllGroupsByStatus(),
            'attachmentList' => Attachment::getAttachmentsArray(),
        ) );


    } );

    Route::get( 'profile', function () {
        if ( !Auth::check() ) {
            return Redirect::to( 'login' );
        }

        return View::make( 'dashboard.profile' );
    } );

    Route::get( 'managetemplate', function () {
        if ( !Auth::check() ) {
            return Redirect::to( 'login' );
        }

        return View::make( 'dashboard.managetemplate', array(
            'content' => Template::getModifyUsage()
        ) );
    } );

    Route::post( 'deleteGroup', 'GroupController@deleteGroup' );

    Route::post( 'addNewGroup', 'GroupController@addNewGroup' );

    Route::post( 'updateGroup', 'GroupController@updateGroup' );

    Route::post( 'AddToMailingList', 'MailingListController@addNewMail' );

    Route::post( 'getMailsToDelete', 'MailingListController@getMails' );

    Route::post( 'deleteMails', 'MailingListController@deleteMails' );

    Route::post( 'sendMail', 'EmailController@send' );

    Route::post( 'getContent', function () {

        if ( Input::get( 'template-modify', 0 ) == 0 ) {
            return View::make( 'dashboard.send', array(
                'content'        => Template::getTemplateContent( Input::get( 'TID' ) ),
                'groupsByStatus' => Group::getAllGroupsByStatus(),
                'attachmentList' => Attachment::getAttachmentsArray(),
            ) );
        } else {
            return View::make( 'dashboard.managetemplate', array(
                'content'        => Template::getTemplateContent( Input::get( 'TID' ) ),
                'attachmentList' => Attachment::getAttachmentsArray(),
            ) );
        }
    } );

    Route::post( 'saveTemplate', function () {

        $data = Template::putTemplateContents( Input::get( 'TID' ), Input::get( 'content' ), Input::get( 'contains' ) );

        return View::make( 'dashboard.manageTemplate', array(
            'content' => $data ['content'],
            'success' => $data ['success'],
            'message' => $data ['message']
        ) );
    } );
