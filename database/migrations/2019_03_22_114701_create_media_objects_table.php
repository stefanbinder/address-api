<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('media_objects', function (Blueprint $table) {

            $table->increments('id');
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->integer('media_objectable_id')->nullable();
            $table->string('media_objectable_type')->nullable();
            $table->string('type')->nullable();

            $table->string('contentSize')->nullable();

            $table->string('contentUrl')->nullable();
            $table->string('contentUrl1024')->nullable();
            $table->string('thumbnailUrl100')->nullable();
            $table->string('thumbnailUrl400')->nullable();

            $table->string('headline')->nullable();
            $table->string('description')->nullable();

            $table->string('encodingFormat')->nullable();
            $table->string('genre')->nullable();
            $table->string('keywords')->nullable();

            $table->integer('publisher_id')->nullable();
            $table->integer('uploader_id')->nullable();

            $table->string('service_id')->nullable(); // yt-id, etc.
            $table->string('service_type')->nullable(); // youtube, vimeo, etc.

        });

        Schema::create('media_objectable', function(Blueprint $table) {

            $table->integer('media_object_id');
            $table->integer('media_objectable_id');
            $table->string('media_objectable_type');

            $table->string('type')->nullable();

            $table->timestampsTz();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_objects');
        Schema::dropIfExists('media_objectable');
    }
}
