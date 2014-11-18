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
		return View::make ( 'dashboard.groups');
	}
	return Redirect::to ( 'login' );
} );

Route::get ( 'lists', function () {
	if (Auth::check ()) {
		return View::make ( 'dashboard.lists' );
	}
	return Redirect::to ( 'login' );
} );

Route::get ( 'send', function () {
	if (Auth::check ()) {
		return View::make ( 'dashboard.send' );
	}
	return Redirect::to ( 'login' );
} );

Route::get ( 'profile', function () {
	if (Auth::check ()) {
		return View::make ( 'dashboard.profile' );
	}
	return Redirect::to ( 'login' );
} );

Route::post('deleteGroup', 'GroupController@deleteGroup');

Route::post('addNewGroup', 'GroupController@addNewGroup');

