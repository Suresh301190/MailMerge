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
			$table->engine = 'InnoDB';
			$table->string ( 'bcc_id', 100 );
			$table->foreign('bcc_id')->references('gid_name')->on('groups')->onUpdate('cascade');
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
