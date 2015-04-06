<?php

namespace estvoyage\value\tests\units\string;

require __DIR__ . '/../../runner.php';

use
	estvoyage\value\tests\units
;

class regex extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isAbstract
			->extends('estvoyage\value\string\notEmpty')
		;
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	function testConstructorWithInvalidValue($invalidValue)
	{
		$this->exception(function() use ($invalidValue) {
				$this->newTestedInstance($invalidValue);
			}
		)
			->isInstanceOf('domainException')
			->hasMessage('Regular expression should be a valid PCRE pattern')
		;
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	function testValidateWithInvalidValue($invalidValue)
	{
		$this->boolean(\estvoyage\value\string\regex::validate($invalidValue))->isFalse;
	}

	protected function invalidValueProvider()
	{
		return [
			'',
			'@',
			uniqid()
		];
	}
}
