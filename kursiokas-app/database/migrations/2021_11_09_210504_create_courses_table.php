<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
        	$table->id();
		  	$table->string('name');
		  	$table->date('date');
		  	$table->time('time');
			$table->string('scope');
		  	$table->integer('seats')->unsigned();
		  	$table->string('address');
		  	$table->decimal('price');
		  	$table->text('description');
		  	$table->string('city');
		  	$table->string('image')->default('/images/image.png');
			$table->boolean('registeringAllowed')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
		foreach(scandir('./public/images') as $file){
			if(!str_starts_with($file, '.') && $file != 'image.png'){
				unlink("./public/images/$file");
			}
		}
    }
}
