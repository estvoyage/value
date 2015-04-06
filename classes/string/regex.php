<?php

namespace estvoyage\value\string;

use
	estvoyage\value\string
;

abstract class regex extends string\notEmpty
{
	function __construct($value)
	{
		$domainException = null;

		try
		{
			parent::__construct($value);
		}
		catch (\domainException $domainException) {}

		if ($domainException || ! self::isValidRegex($value))
		{
			throw new \domainException('Regular expression should be a valid PCRE pattern');
		}
	}

	static function validate($value)
	{
		return parent::validate($value) && self::isValidRegex($value);
	}

	private static function isValidRegex($value)
	{
		$previousErrorHandler = set_error_handler(function($errno, $errstr) {});

		$isValidRegex = preg_match($value, '') !== false;

		set_error_handler($previousErrorHandler);

		return $isValidRegex;
	}
}
