<?php

namespace estvoyage\value\float;

use
	estvoyage\value\float
;

abstract class unsigned extends float
{
	function __construct($value = 0.)
	{
		$invalid = false;

		try
		{
			parent::__construct($value);
		}
		catch (\domainException $exception)
		{
			$invalid = true;
		}

		if ($invalid || ! static::isUnsigned($value))
		{
			throw new \domainException('Value should be a float greater than or equal to 0.');
		}
	}

	static function validate($value)
	{
		return parent::validate($value) && self::isUnsigned($value);
	}

	private static function isUnsigned($value)
	{
		return $value >= 0.;
	}
}
