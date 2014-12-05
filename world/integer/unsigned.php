<?php

namespace estvoyage\value\world\integer;

use
	estvoyage\value\world\integer
;

trait unsigned
{
	use integer {
		validate as private isInteger;
	}

	function __construct($value = 0)
	{
		if (! self::validate($value))
		{
			throw new \domainException('Value should be an integer greater than or equal to 0');
		}

		self::initAsInteger($value);
	}

	static function validate($value)
	{
		return self::isInteger($value) && self::isUnsigned($value);
	}

	private static function isUnsigned($value)
	{
		return $value >= 0;
	}
}
