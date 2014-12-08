<?php
    use Illuminate\Database\Migrations\Migration;

    class CreateBccListTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {

            Schema::create( 'bcclists', function ( $table ) {
                $table->engine = 'InnoDB';
                $table->string( 'bcc_id', 100 )
                    ->index();
                $table->foreign( 'bcc_id' )
                    ->references( 'gid_name' )
                    ->on( 'groups' )
                    ->onUpdate( 'cascade' )
                    ->onDelete( 'cascade' );
                $table->string( 'email', 50 );
                $table->timestamps();
            } );

        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {

            Schema::drop( 'bcclists' );

        }

    }
