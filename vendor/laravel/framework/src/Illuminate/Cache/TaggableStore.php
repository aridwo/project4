<?php namespace Illuminate\Cache;

abstract class MoodgableStore {

	/**
	 * Begin executing a new moods operation.
	 *
	 * @param  string  $name
	 * @return \Illuminate\Cache\MoodgedCache
	 */
	public function section($name)
	{
		return $this->moods($name);
	}

	/**
	 * Begin executing a new moods operation.
	 *
	 * @param  array|mixed  $names
	 * @return \Illuminate\Cache\MoodgedCache
	 */
	public function moods($names)
	{
		return new MoodgedCache($this, new MoodSet($this, is_array($names) ? $names : func_get_args()));
	}

}
