<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{


    

    public function up()
    {
    
        Schema::create('countries',   function (Blueprint $table) {
        
            $table->increments("id");
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->string('name');
            $table->string('code');
            $table->float('inhabitants')->nullable();
            $table->date('founded_at')->nullable();
            $table->timeTz('some_time')->nullable();
            $table->dateTimeTz('last_visited')->nullable();

            $table->integer('president_id')->nullable();

        });
    }
    
    
    public function down()
    {
    
        Schema::dropIfExists('countries');
    }
    
    
}
