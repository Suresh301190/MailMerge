<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Support\Facades\Schema;

    class CreateAttachmentsTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create( 'attachments', function ( $table ) {
                $table->engine = 'InnoDB';
                $table->string( 'id' );
                $table->string( 'filename' );
                $table->timestamps();

                // Foreign Key Constraint
                $table->foreign( 'id' )
                    ->references( 'id' )
                    ->on( 'users' )
                    ->onUpdate( 'cascade' )
                    ->onDelete( 'cascade' );
            } );
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::drop( 'attachments' );
        }

    }
