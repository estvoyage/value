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
		$this->float((new float\testedClass)->asFloat)->isZero;
	}

	/**
	 * @dataProvider validValueDataProvider
	 */
	function testBuildWithValidValue($value)
	{
		$this->float((new float\testedClass($value))->asFloat)->isEqualTo((float) $value);
	}

	/**
	 * @dataProvider invalidValueDataProvider
	 */
	function testBuildWithInvalidValue($value)
	{
		$this
			->exception(function() use ($value) { new float\testedClass($value); })
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
				$float = new float\testedClass($value)
			)
			->then
				->exception(function() use ($float) { $float->asFloat = uniqid(); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($float) . ' is immutable')

				->exception(function() use ($float) { $float->{uniqid()} = uniqid(); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($float) . ' is immutable')

				->exception(function() use ($float) { unset($float->asFloat); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($float) . ' is immutable')

				->exception(function() use ($float) { unset($float->{uniqid()}); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($float) . ' is immutable')
		;
	}

	function testPropertiesAvailability()
	{
		$this
			->if(
				$float = new float\testedClass
			)
			->then
				->boolean(isset($float->asFloat))->isTrue
				->boolean(isset($float->{uniqid()}))->isFalse
				->exception(function() use ($float, & $property) { $float->{$property = uniqid()}; })
					->isInstanceOf('logicException')
					->hasMessage('Undefined property: ' . get_class($float) . '::' . $property)
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
