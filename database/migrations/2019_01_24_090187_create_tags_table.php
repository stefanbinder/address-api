<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{


    

    public function up()
    {
    
        Schema::create('tags',   function (Blueprint $table) {
        
            $table->increments("id");
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->string('name')->nullable();
            
        });
    }
    
    
    public function down()
    {
    
        Schema::dropIfExists('tags');
    }
    
    
}
