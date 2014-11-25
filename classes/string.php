<?php

namespace estvoyage\value;

abstract class string extends generic
{
	function __construct($value = '')
	{
		if (! static::validate($value))
		{
			throw new \domainException('Value should be a string');
		}

		parent::__construct($value);
	}

	function __toString()
	{
		return $this->value;
	}

	static function validate($value)
	{
		return is_string($value);
	}
}
