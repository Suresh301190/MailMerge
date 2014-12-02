<?php
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create ( 'groups', function ($table) {
            $table->engine = 'InnoDB';
            $table->string ( 'gid', 50 );
            $table->string ( 'gname', 50 );
            $table->string ( 'gid_name', 100 )->unique ();
            $table->string ( 'hr_name', 50 );
            $table->string ( 'company', 50 );
            $table->enum ('state', array('invite', 'follow', 'confirm'));
            // $table->string ( 'cc_list', 50 )->unique ();
            // $table->string ( 'bcc_list', 50 )->unique ();
            $table->timestamps ();
            
            $table->primary ( array (
                    'gid',
                    'gname'
            ) );
            
            $table->foreign ( 'gid' )->references ( 'id' )->on ( 'users' )->onUpdate ( 'cascade' );
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
