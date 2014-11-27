<?php

namespace estvoyage\value;

abstract class integer extends generic
{
	function __construct($value = 0)
	{
		if (! static::validate($value))
		{
			throw new \domainException('Value should be an integer');
		}

		parent::__construct([ 'asInteger' => $value ]);
	}

	function __toString()
	{
		return (string) $this->asInteger;
	}

	static function validate($value)
	{
		return is_int($value);
	}
}
