<?php

namespace estvoyage\value\tests\units\string;

require __DIR__ . '/../../runner.php';

use
	estvoyage\value\tests\units
;

class notEmpty extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isAbstract
			->extends('estvoyage\value\string')
		;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testConstructorWithValidValue($value)
	{
		$this
			->if(
				$string = new notEmpty\testedClass($value)
			)
			->then
				->string($string->asString)->isEqualTo($value)
				->castToString($string)->isEqualTo($value)
		;
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	function testConstructorWithInvalidValue($value)
	{
		$this
			->exception(function() use ($value) { new notEmpty\testedClass($value); })
				->isInstanceOf('domainException')
				->hasMessage('Value should be a not empty string')
		;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testValidateWithValidValue($value)
	{
		$this->boolean(notEmpty\testedClass::validate($value))->isTrue;
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	function testValidateWithInvalidValue($value)
	{
		$this->boolean(notEmpty\testedClass::validate($value))->isFalse;
	}

	protected function validValueProvider()
	{
		return [
			uniqid()
		];
	}

	protected function invalidValueProvider()
	{
		return [
			true,
			false,
			null,
			rand(- PHP_INT_MAX, 1),
			0,
			rand(1, PHP_INT_MAX),
			(float) rand(- PHP_INT_MAX, 1),
			0.,
			M_PI,
			(float) rand(1, PHP_INT_MAX)
			[ [] ],
			new \stdclass,
			''
		];
	}
}

namespace estvoyage\value\tests\units\string\notEmpty;

class testedClass extends \estvoyage\value\string\notEmpty
{
}
