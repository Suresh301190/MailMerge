<?php
    use Illuminate\Database\Migrations\Migration;

    class CreateGroupsTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {

            Schema::create( 'groups', function ( $table ) {
                $table->engine = 'InnoDB';
                $table->string( 'gid', 50 )
                    ->index();
                $table->string( 'gname', 50 )
                    ->index();
                $table->string( 'gid_name', 100 )
                    ->unique()
                    ->index();

                $table->dateTime( 'reminder' )
                    ->default( null );
                $table->string( 'hr_name', 50 );
                $table->string( 'company', 50 );
                $table->enum( 'state', array( 'invite', 'follow', 'confirm', 'confirmed' ) );

                $table->timestamps();

                $table->primary( array(
                    'gid',
                    'gname'
                ) );

                $table->foreign( 'gid' )
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

            Schema::drop( 'groups' );

        }

    }
