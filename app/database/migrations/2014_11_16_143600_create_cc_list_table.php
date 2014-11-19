<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCcListTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create ( 'cclists', function ($table) {
            $table->engine = 'InnoDB';
            $table->string ( 'cc_id', 100 )->primary ();
            $table->foreign ( 'cc_id' )->references ( 'gid_name' )->on ( 'groups' )->onUpdate ( 'cascade' )->onDelete ( 'cascade' );
            $table->string ( 'email', 50 );
            $table->timestamps ();
        } );
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::drop ( 'cclists' );
    
    }

}
