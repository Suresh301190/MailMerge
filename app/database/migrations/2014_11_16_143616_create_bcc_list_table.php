<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBccListTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create ( 'bcclists', function ($table) {
			$table->string ( 'type_list', 50 );
			$table->foreign('type_list')->references('bcc_list')->on('groups')->onUpdate('cascade');
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
		Schema::drop('bcclists');
	}

}
