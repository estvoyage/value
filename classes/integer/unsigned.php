<?php

namespace estvoyage\value\integer;

use
	estvoyage\value\integer
;

abstract class unsigned extends integer
{
	function __construct($value = 0)
	{
		if (! static::validate($value))
		{
			throw new \domainException('Value should be an integer greater than or equal to 0');
		}

		parent::__construct($value);
	}

	static function validate($value)
	{
		return parent::validate($value) && $value >= 0;
	}
}
