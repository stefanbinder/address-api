<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExampleRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagables', function(Blueprint $table ) {
            $table->integer('tag_id');
            $table->integer('tagable_id');
            $table->string('tagable_type');

            $table->timestampsTz();
            $table->softDeletesTz();
        });

        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->string('name');
        });

        Schema::create('country_vendor', function (Blueprint $table) {
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->integer('vendor_id');
            $table->integer('country_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
