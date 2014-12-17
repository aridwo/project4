<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageMoodTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	# Create pivot table connecting `images` and `moods`
	public function up() 
	{
		Schema::create('image_mood', function($table) {

			# AI, PK
			# none needed

			# General data...
			$table->integer('image_id')->unsigned();
			$table->integer('mood_id')->unsigned();
			
			# Define foreign keys...
			$table->foreign('image_id')->references('id')->on('images');
			$table->foreign('mood_id')->references('id')->on('moods');
			 $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');   
			  $table->foreign('mood_id')->references('id')->on('moods')->onDelete('cascade');  
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('image_mood');
	}

}
