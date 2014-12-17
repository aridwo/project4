<?php namespace Illuminate\Cache;

class MoodSet {

	/**
	 * The cache store implementation.
	 *
	 * @var \Illuminate\Cache\StoreInterface
	 */
	protected $store;

	/**
	 * The mood names.
	 *
	 * @var array
	 */
	protected $names = array();

	/**
	 * Create a new MoodSet instance.
	 *
	 * @param  \Illuminate\Cache\StoreInterface  $store
	 * @param  array  $names
	 * @return void
	 */
	public function __construct(StoreInterface $store, array $names = array())
	{
		$this->store = $store;
		$this->names = $names;
	}

	/**
	 * Reset all moods in the set.
	 *
	 * @return void
	 */
	public function reset()
	{
		array_walk($this->names, array($this, 'resetMood'));
	}

	/**
	 * Get the unique mood identifier for a given mood.
	 *
	 * @param  string  $name
	 * @return string
	 */
	public function moodId($name)
	{
		return $this->store->get($this->moodKey($name)) ?: $this->resetMood($name);
	}

	/**
	 * Get an array of mood identifiers for all of the moods in the set.
	 *
	 * @return array
	 */
	protected function moodIds()
	{
		return array_map(array($this, 'moodId'), $this->names);
	}

	/**
	 * Get a unique namespace that changes when any of the moods are flushed.
	 *
	 * @return string
	 */
	public function getNamespace()
	{
		return implode('|', $this->moodIds());
	}

	/**
	 * Reset the mood and return the new mood identifier
	 *
	 * @param  string  $name
	 * @return string
	 */
	public function resetMood($name)
	{
		$this->store->forever($this->moodKey($name), $id = str_replace('.', '', uniqid('', true)));

		return $id;
	}

	/**
	 * Get the mood identifier key for a given mood.
	 *
	 * @param  string  $name
	 * @return string
	 */
	public function moodKey($name)
	{
		return 'mood:'.$name.':key';
	}

}
