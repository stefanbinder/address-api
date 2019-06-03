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
            $table->string('code2');
            $table->string('code3');

            $table->integer('capital_id')->nullable();
            $table->integer('region_id')->nullable();
        });
    }
    
    
    public function down()
    {
    
        Schema::dropIfExists('countries');
    }
    
    
}
