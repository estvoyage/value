<?php

namespace estvoyage\value\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\value\tests\units
;

class float extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isAbstract
			->extends('estvoyage\value\generic')
		;
	}

	function testBuildWithNoArgument()
	{
		$this->float(float\testedClass::build()->value)->isZero;
	}

	/**
	 * @dataProvider validValueDataProvider
	 */
	function testBuildWithValidValue($value)
	{
		$this->float(float\testedClass::build($value)->value)->isEqualTo((float) $value);
	}

	/**
	 * @dataProvider invalidValueDataProvider
	 */
	function testBuildWithInvalidValue($value)
	{
		$this
			->exception(function() use ($value) { float\testedClass::build($value); })
				->isInstanceOf('domainException')
				->hasMessage('Value should be numeric')
		;
	}

	/**
	 * @dataProvider validValueDataProvider
	 */
	function testValidateWithValidValue($value)
	{
		$this->boolean(float\testedClass::validate($value))->isTrue;
	}

	/**
	 * @dataProvider invalidValueDataProvider
	 */
	function testValidateWithInvalidValue($value)
	{
		$this->boolean(float\testedClass::validate($value))->isFalse;
	}

	/**
	 * @dataProvider validValueDataProvider
	 */
	function testImmutability($value)
	{
		$this
			->if(
				$float = float\testedClass::build($value)
			)
			->then
				->exception(function() use ($float) { $float->value = uniqid(); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($float) . ' is immutable')

				->exception(function() use ($float) { $float->{uniqid()} = uniqid(); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($float) . ' is immutable')

				->exception(function() use ($float) { unset($float->value); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($float) . ' is immutable')

				->exception(function() use ($float) { unset($float->{uniqid()}); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($float) . ' is immutable')
		;
	}

	protected function validValueDataProvider()
	{
		return [
			rand(- PHP_INT_MAX, 1),
			0,
			rand(1, PHP_INT_MAX),
			(float) rand(- PHP_INT_MAX, 1),
			0.,
			M_PI,
			(float) rand(1, PHP_INT_MAX)
		];
	}

	protected function invalidValueDataProvider()
	{
		return [
			true,
			false,
			'',
			uniqid(),
			null,
			[ [] ],
			new \stdclass,
			(string) (float) rand(- PHP_INT_MAX, 1),
			(string) 0.,
			(string) M_PI,
			(string) (float) rand(1, PHP_INT_MAX)
		];
	}
}

namespace estvoyage\value\tests\units\float;

class testedClass extends \estvoyage\value\float
{
}
