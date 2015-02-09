<?php

namespace estvoyage\value;

abstract class string
{
	use immutable;

	function __construct($value = '')
	{
		if (! self::validate($value))
		{
			throw new \domainException('Value should be a string');
		}

		$this->init([ 'asString' => $value ]);
	}

	function __toString()
	{
		return $this->asString;
	}

	static function validate($value)
	{
		return is_string($value);
	}
}
