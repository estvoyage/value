<?php

namespace estvoyage\value;

trait unsigned
{
	private static function isUnsigned($value)
	{
		return $value >= 0;
	}
}
