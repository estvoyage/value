<?php

namespace estvoyage\value;

abstract class float extends generic
{
	function __construct($value = 0.)
	{
		if (! static::validate($value))
		{
			throw new \domainException('Value should be numeric');
		}

		parent::__construct([ 'asFloat' => (float) $value ]);
	}

	static function validate($value)
	{
		return is_float($value) || is_int($value);
	}
}
