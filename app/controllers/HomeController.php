<?php
class HomeController extends BaseController {
	
	/*
	 * |--------------------------------------------------------------------------
	 * | Default Home Controller
	 * |--------------------------------------------------------------------------
	 * |
	 * | You may wish to use controllers instead of, or in addition to, Closure
	 * | based routes. That's great! Here is an example controller method to
	 * | get you started. To route to this controller, just add the route:
	 * |
	 * | Route::get('/', 'HomeController@showWelcome');
	 * |
	 */
	public function showWelcome() {
		$user = DB::select ( 'select * from users where id = ?', array (
				Auth::user ()->id 
		) );
		if (! count ( $user ))
			DB::insert ( 'insert into users (id, name, email) values (?, ?, ?)', array (
					Auth::user ()->id,
					Auth::user ()->name,
					Auth::user ()->email 
			) );
		return View::make ( 'dashboard.home' );
	}
}
