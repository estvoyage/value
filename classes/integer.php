<?php

namespace estvoyage\value;

abstract class integer
{
	use immutable;

	function __construct($value = 0)
	{
		if (! self::validate($value))
		{
			throw new \domainException('Value should be an integer');
		}

		$this->init([ 'asInteger' => (int) $value ]);
	}

	function __toString()
	{
		return (string) $this->asInteger;
	}

	static function validate($value)
	{
		// Why not using filter_var($value, FILTER_VALIDATE_INT) here ?
		// Because if $value is a float (i.e. (float) rand(1, PHP_INT_MAX)) and strlen($value) > ini_get('precision'), filter_var return false :/
		return is_numeric($value) && (int) $value == $value;
	}
}
