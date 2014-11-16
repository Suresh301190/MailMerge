<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCcListTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create ( 'cclists', function ($table) {
			$table->string ( 'type_list', 50 );
			$table->foreign('type_list')->references('cc_list')->on('groups')->onUpdate('cascade');
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
		Schema::drop('cclists');
	}

}
