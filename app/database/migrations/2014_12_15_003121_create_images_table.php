<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('images', function($table) {

			# AI, PK
			$table->increments('id');
			
			# created_at, updated_at columns
			$table->timestamps();
			
			# General data...
			$table->string('title');
			$table->integer('author_id')->unsigned(); # Important! FK has to be unsigned because the PK it will reference is auto-incrementing
	$table->string('photo');
	
			
			# Define foreign keys...
			$table->foreign('author_id')->references('id')->on('authors');
			

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('images');
	}

}
