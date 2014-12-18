<?php

class Image extends Eloquent {

    # The guarded properties specifies which attributes should *not* be mass-assignable
    protected $guarded = array('id', 'created_at', 'updated_at');

    /**
    * Image belongs to Author
    * Define an inverse one-to-many relationship.
    */
	public function author() {

        return $this->belongsTo('Author');

    }

    /**
    * Images belong to many Moods
    */
    public function moods() {

        return $this->belongsToMany('Mood');

    }

    /**
    * This array will compare an array of given moods with existing moods
    * and figure out which ones need to be added and which ones need to be deleted
    */
    public function updateMoods($new = array()) {

        // Go through new moods to see what ones need to be added
        foreach($new as $mood) {
            if(!$this->moods->contains($mood)) {
                $this->moods()->save(Mood::find($mood));
            }
        }

        // Go through existing moods and see what ones need to be deleted
        foreach($this->moods as $mood) {
            if(!in_array($mood->pivot->mood_id,$new)) {
                $this->moods()->detach($mood->id);
            }
        }
    }

    /**
    * Search among images, authors and moods
    * @return Collection
    */
    public static function search($query) {

        # If there is a query, search the library with that query
        if($query) {

            # Eager load moods and author
            $images = Image::with('moods','author')
            ->whereHas('author', function($q) use($query) {
                $q->where('name', 'LIKE', "%$query%");
            })
            ->orWhereHas('moods', function($q) use($query) {
                $q->where('name', 'LIKE', "%$query%");
            })
            ->orWhere('title', 'LIKE', "%$query%")
            ->get();

            
        }
        # Otherwise, just fetch all images
        else {
            # Eager load moods and author
            $images = Image::with('moods','author')->get();
        }

        return $images;
    }




    /**
    *
    *
    * @return String
    */
    public static function sendDigests($users,$images) {

        $recipients = '';

        $data['images'] = $images;

        foreach($users as $user) {

            $data['user'] = $user;

            /*
            Mail::send('emails.digest', $data, function($message) {

                $recipient_email = $user->email;
                $recipient_name  = $user->first_name.' '.$user->last_name;
                $subject  = 'Mood Bank Digest';

                $message->to($recipient_email, $recipient_name)->subject($subject);

            });
            */

            $recipients .= $user->email.', ';

        }

        $recipients = rtrim($recipients, ',');

        return $recipients;

    }


}