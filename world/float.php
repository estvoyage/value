<?php

namespace estvoyage\value\world;

trait float
{
	use immutable;

	function __construct($value = 0.)
	{
		if (! static::validate($value))
		{
			throw new \domainException('Value should be numeric');
		}

		self::initAsFloat($value);
	}

	function __toString()
	{
		return (string) $this->asFloat;
	}

	static function validate($value)
	{
		return is_numeric($value);
	}

	private function initAsFloat($value)
	{
		self::init([ 'asFloat' => (float) $value ]);
	}
}
