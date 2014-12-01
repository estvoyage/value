<?php

namespace estvoyage\value\integer;

use
	estvoyage\value\integer
;

abstract class unsigned extends integer
{
	function __construct($value = 0)
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
			throw new \domainException('Value should be an integer greater than or equal to 0');
		}

		parent::__construct($value);
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
