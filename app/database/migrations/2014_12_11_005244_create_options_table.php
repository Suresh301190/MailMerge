<?php

    use Illuminate\Database\Migrations\Migration;

    class CreateOptionsTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create( 'options', function ( $table ) {
                $table->string( 'key' )
                    ->primary();
                $table->string( 'value' );
            } );
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::drop( 'options' );
        }

    }
