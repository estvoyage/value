<?php

namespace estvoyage\value\string;

use
	estvoyage\value
;

abstract class notEmpty extends value\string
{
	function __construct($value)
	{
		$domainException = null;

		try
		{
			parent::__construct($value);
		}
		catch (\domainException $domainException) {}

		if ($domainException || ! self::isNotEmpty($value))
		{
			throw new \domainException('Value should be a not empty string');
		}
	}

	static function validate($value)
	{
		return parent::validate($value) && self::isNotEmpty($value);
	}

	private static function isNotEmpty($value)
	{
		return $value != '';
	}
}
