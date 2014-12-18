<?php

class FooimagesSeeder extends Seeder {

	public function run() {

		# Clear the tables to a blank slate
		DB::statement('SET FOREIGN_KEY_CHECKS=0'); # Disable FK constraints so that all rows can be deleted, even if there's an associated FK
		DB::statement('TRUNCATE images');
		DB::statement('TRUNCATE authors');
		DB::statement('TRUNCATE moods');
		DB::statement('TRUNCATE image_mood');
		DB::statement('TRUNCATE users');

		# Photographers
		$acaso = new Author;
		$acaso->name = 'Anne Acaso';
		$acaso->save();

	

		# Moods (Created using the Model Create shortcut method)
		# Note: Moods model must have `protected $fillable = array('name');` in order for this to work
		$happy         = Mood::create(array('name' => 'happy'));
		$sad       = Mood::create(array('name' => 'sad'));
		$angry    = Mood::create(array('name' => 'angry'));
		$scared       = Mood::create(array('name' => 'scared'));
		$disgusted        = Mood::create(array('name' => 'disgusted'));
		$surprised         = Mood::create(array('name' => 'surprised'));
		

		# Images
		$balloons = new Image;
		$balloons->title = 'Girl with Balloons';
		$balloons->photo = 'http://oi59.tinypic.com/o8s68n.jpg';
		

		# Associate has to be called *before* the image is created (save())
		$balloons->author()->associate($acaso); # Equivalent of $balloons->author_id = $acaso->id
		$balloons->save();

		# Attach has to be called *after* the image is created (save()),
		# since resulting `image_id` is needed in the image_mood pivot table
		$balloons->moods()->attach($happy);
		



		$user = new User;
		$user->email      = 'janedoe@email.com';
		$user->password   = Hash::make('janedoe');
		$user->first_name = 'Jane';
		$user->last_name  = 'Doe';
		$user->save();


	}

}