<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{


    

    public function up()
    {
    
        Schema::create('states',   function (Blueprint $table) {
        
            $table->increments("id");
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->string('name');
            $table->integer('country_id')->nullable();
            
        });
    }
    
    
    public function down()
    {
    
        Schema::dropIfExists('states');
    }
    
    
}
