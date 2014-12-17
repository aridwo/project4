<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	# Create the moods table
	public function up() 
	{
		Schema::create('moods', function($table) {
			
			# AI, PK
			$table->increments('id');
			
			# created_at, updated_at columns
			$table->timestamps();
			
			# General data....
			$table->string('name', 64);
			
			# Define foreign keys...
			

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('moods');
	}

}
