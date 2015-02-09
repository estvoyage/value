<?php

namespace estvoyage\value\float;

use
	estvoyage\value
;

abstract class unsigned extends value\float
{
	use value\unsigned;

	function __construct($value = 0.)
	{
		$domainException = null;

		try
		{
			parent::__construct($value);
		}
		catch (\domainException $domainException) {}

		if ($domainException || ! self::isUnsigned($value))
		{
			throw new \domainException('Value should be a float greater than or equal to 0.');
		}
	}

	static function validate($value)
	{
		return parent::validate($value) && self::isUnsigned($value);
	}
}
