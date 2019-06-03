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

        Schema::create('tagables', function(Blueprint $table ) {
            $table->integer('tag_id');
            $table->integer('tagable_id');
            $table->string('tagable_type');

            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }
    
    public function down()
    {
    
        Schema::dropIfExists('tags');
        Schema::dropIfExists('tagables');
    }
    
    
}
