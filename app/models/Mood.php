<?php

class Mood extends Eloquent {

	# Enable fillable on the 'name' column so we can use the Model shortcut Create
	protected $fillable = array('name');

    public function images() {
        # Moods belong to many Images
        return $this->belongsToMany('Image');
    }


	# Model events...
	# http://laravel.com/docs/eloquent#model-events
	public static function boot() {

        parent::boot();

        static::deleting(function($mood) {
            DB::statement('DELETE FROM image_mood WHERE mood_id = ?', array($mood->id));
        });

	}

    /**
    *
    * @return Array
    */
    public static function getIdNamePair() {

        $moods = Array();

        $collection = Mood::all();

        foreach($collection as $mood) {
            $moods[$mood->id] = $mood->name;
        }

        return $moods;
    }


}