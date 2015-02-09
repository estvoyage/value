<?php

namespace estvoyage\value;

abstract class float
{
	use immutable;

	function __construct($value = 0.)
	{
		if (! self::validate($value))
		{
			throw new \domainException('Value should be numeric');
		}

		$this->init([ 'asFloat' => (float) $value ]);
	}

	function __toString()
	{
		return (string) $this->asFloat;
	}

	static function validate($value)
	{
		return is_numeric($value);
	}
}
