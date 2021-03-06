<?php namespace Laravel;

class Arr {

	/**
	 * Get an item from an array.
	 *
	 * If the specified key is null, the entire array will be returned. The array may
	 * also be accessed using JavaScript "dot" style notation. Retrieving items nested
	 * in multiple arrays is also supported.
	 *
	 * <code>
	 *		// Returns "taylor"
	 *		Arr::get(array('name' => array('is' => 'Taylor')), 'name.is');
	 * </code>
	 *
	 * @param  array   $array
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public static function get($array, $key, $default = null)
	{
		if (is_null($key)) return $array;

		foreach (explode('.', $key) as $segment)
		{
			if ( ! is_array($array) or ! array_key_exists($segment, $array))
			{
				return ($default instanceof \Closure) ? call_user_func($default) : $default;
			}

			$array = $array[$segment];
		}

		return $array;
	}

	/**
	 * Set an array item to a given value.
	 *
	 * This method is primarly helpful for setting the value in an array with
	 * a variable depth, such as configuration arrays.
	 *
	 * If the specified item doesn't exist, it will be created. If the item's
	 * parents do no exist, they will also be created as arrays.
	 *
	 * Like the Arr::get method, JavaScript "dot" syntax is supported.
	 *
	 * <code>
	 *		// Set "name.is" to "taylor"
	 *		Arr::set(array('name' => array('is' => 'something')), 'name.is', 'taylor');		
	 * </code>
	 *
	 * @param  array   $array
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public static function set(&$array, $key, $value)
	{
		if (is_null($key)) return $array = $value;

		$keys = explode('.', $key);

		while (count($keys) > 1)
		{
			$key = array_shift($keys);

			if ( ! isset($array[$key]) or ! is_array($array[$key]))
			{
				$array[$key] = array();
			}

			$array =& $array[$key];
		}

		$array[array_shift($keys)] = $value;
	}

}