<?php

namespace estvoyage\value\world\float;

use
	estvoyage\value\world\float
;

trait unsigned
{
	use float {
		validate as private isFloat;
	}

	function __construct($value = 0.)
	{
		if (! self::validate($value))
		{
			throw new \domainException('Value should be a float greater than or equal to 0.');
		}

		$this->initAsFloat($value);
	}

	static function validate($value)
	{
		return self::isFloat($value) && self::isUnsigned($value);
	}

	private static function isUnsigned($value)
	{
		return $value >= 0.;
	}
}
