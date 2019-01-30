<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{


    

    public function up()
    {
    
        Schema::create('people',   function (Blueprint $table) {
        
            $table->increments("id");
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->string('additional_name')->nullable();
            $table->string('given_name');
            $table->string('family_name');
            $table->string('email')->nullable();
            
        });
    }
    
    
    public function down()
    {
    
        Schema::dropIfExists('people');
    }
    
    
}
