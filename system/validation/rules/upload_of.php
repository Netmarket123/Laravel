<?php namespace System\Validation\Rules;

use System\File;
use System\Input;
use System\Validation\Rule;

class Upload_Of extends Rule {

	/**
	 * The acceptable file extensions.
	 *
	 * @var array
	 */
	public $extensions;

	/**
	 * The maximum file size in bytes.
	 *
	 * @var int
	 */
	public $maximum;

	/**
	 * Evaluate the validity of an attribute.
	 *
	 * @param  string  $attribute
	 * @param  array   $attributes
	 * @return void
	 */
	public function check($attribute, $attributes)
	{
		if ( ! array_key_exists($attribute, Input::file()))
		{
			return true;
		}

		$file = Input::file($attribute);

		if ( ! is_null($this->maximum) and $file['size'] > $this->maximum)
		{
			return false;
		}

		if ( ! is_null($this->extensions) and ! in_array(File::extension($file['name']), $this->extensions))
		{
			return false;
		}

		return true;
	}

	/**
	 * Set the acceptable file extensions.
	 *
	 * @return Upload_Of
	 */
	public function has_extension()
	{
		$this->extensions = func_get_args();
		return $this;
	}

	/**
	 * Set the maximum file size in bytes.
	 *
	 * @param  int  $maximum
	 * @return Upload_Of
	 */
	public function less_than($maximum)
	{
		$this->maximum = $maximum;
		return $this;
	}

}