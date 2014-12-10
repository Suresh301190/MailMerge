<?php

    use Illuminate\Database\Migrations\Migration;

    class CreateSentMailsTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create( 'sent_mails', function ( $table ) {
                $table->string( 'uid' )
                    ->index();
                $table->string( 'gname' )
                    ->index();
                $table->enum( 'type', array( 'invite', 'follow', 'confirm' ) )
                    ->index();
                $table->enum( 'status', array( 'sending', 'sent', 'failed' ) )
                    ->index();
                $table->timestamps();

                // primary key (Composite Key)
                $table->primary( array( 'uid', 'gname', 'type' ) );

                $table->foreign( 'uid' )
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
            Schema::drop( 'sent_mails' );
        }

    }
