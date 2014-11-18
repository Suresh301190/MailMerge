<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToListTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create ( 'tolists', function ($table) {
			$table->engine = 'InnoDB';
			$table->string ( 'to_id', 100 );
			$table->foreign('to_id')->references('gid_name')->on('groups')->onUpdate('cascade');
			$table->string ( 'email', 50 );
			$table->timestamps ();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tolists');
	}

}
