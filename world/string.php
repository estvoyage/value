<?php

namespace estvoyage\value\world;

trait string
{
	use immutable;

	function __construct($value = '')
	{
		if (! static::validate($value))
		{
			throw new \domainException('Value should be a string');
		}

		self::initAsString($value);
	}

	function __toString()
	{
		return $this->asString;
	}

	static function validate($value)
	{
		return is_string($value);
	}

	private function initAsString($value)
	{
		self::init([ 'asString' => $value ]);
	}
}
