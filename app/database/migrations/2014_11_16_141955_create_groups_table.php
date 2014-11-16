<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateGroupsTable extends Migration {
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'groups', function ($table) {
			$table->string ( 'group_name', 50 )->primary ();
			$table->string ( 'to_list', 50 )->unique ();
			$table->string ( 'cc_list', 50 )->unique ();
			$table->string ( 'bcc_list', 50 )->unique ();
			$table->timestamps ();
		} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop ( 'groups' );
	}
}
