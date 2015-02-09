<?php

namespace estvoyage\value\integer;

use
	estvoyage\value
;

abstract class unsigned extends value\integer
{
	function __construct($value = 0)
	{
		$domainException = null;

		try
		{
			parent::__construct($value);
		}
		catch (\domainException $domainException) {}

		if ($domainException || ! self::isUnsigned($value))
		{
			throw new \domainException('Value should be an integer greater than or equal to 0');
		}
	}

	static function validate($value)
	{
		return parent::validate($value) && self::isUnsigned($value);
	}

	private static function isUnsigned($value)
	{
		return $value >= 0;
	}
}
