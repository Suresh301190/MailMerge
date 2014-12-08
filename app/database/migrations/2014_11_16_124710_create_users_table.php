<?php
    use Illuminate\Database\Migrations\Migration;

    class CreateUsersTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create( 'users', function ( $table ) {
                $table->engine = 'InnoDB';
                $table->string( 'id' )
                    ->unique()
                    ->index();
                $table->string( 'name' );
                $table->string( 'email' )
                    ->primary();
                $table->rememberToken()
                    ->nullable();
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
            Schema::drop( 'users' );
        }
    }
