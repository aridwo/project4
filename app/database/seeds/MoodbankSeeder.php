<?php

class MoodbankSeeder extends Seeder {

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

		$akada = new Author;
		$akada->name = 'Ben Akada';
		$akada->save();

		$other = new Author;
$other->name = 'Other';
$other->save();

$getty = new Author;
$getty->name = 'Getty Images';
$getty->save();

$lumsden = new Author;
$lumsden->name = 'Angela Lumsden';
$lumsden->save();

$jpm = new Author;
$jpm->name = 'JPM';
$jpm->save();

$paige = new Author;
$paige->name = 'Sara Lynn Paige';
$paige->save();

$brandnew = new Author;
$brandnew->name = 'Brand New Images';
$brandnew->save();

$getty = new Author;
$getty->name = 'Getty Images';
$getty->save();

$tya = new Author;
$tya->name = 'Ty Allison';
$tya->save();

$otis = new Author;
$otis->name = 'Dmitri Otis';
$otis->save();

$vlad = new Author;
$vlad->name = 'Vladimir Godnik';
$vlad->save();

$lund = new Author;
$lund->name = 'John Lund';
$lund->save();

$glow = new Author;
$glow->name = 'Glow Cuisine';
$glow->save();


	

		# Moods (Created using the Model Create shortcut method)
		
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
		$balloons->author()->associate($acaso); 
		$balloons->save();
		$balloons->moods()->attach($happy);

		$cat = new Image;
		$cat->title = 'Curmudgeon';
		$cat->photo = 'http://oi62.tinypic.com/2lj6k5w.jpg';
		$cat->author()->associate($akada); 
		$cat->save();
		$cat->moods()->attach($angry);
		$cat->moods()->attach($disgusted);

		$sadboy = new Image;
		$sadboy->title = 'Boy with sad expression';
		$sadboy->photo = 'http://oi60.tinypic.com/fm2eqa.jpg';
		$sadboy->author()->associate($lumsden); 
		$sadboy->save();
		$sadboy->moods()->attach($sad);

		



		$user = new User;
		$user->email      = 'janedoe@email.com';
		$user->password   = Hash::make('janedoe');
		$user->first_name = 'Jane';
		$user->last_name  = 'Doe';
		$user->save();


	}

}