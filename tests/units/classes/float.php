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

	/**
	 * @dataProvider validValueDataProvider
	 */
	function testProperties($value)
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

	/**
	 * @dataProvider validValueDataProvider
	 */
	function testEquality($value)
	{
		$this
			->boolean(new float\testedClass($value) == new float\testedClass($value))->isTrue
			->boolean(new float\testedClass($value) == new float\testedClass((float) rand(- PHP_INT_MAX, PHP_INT_MAX)))->isFalse
		;
	}

	protected function validValueDataProvider()
	{
		return [
			'any integer less than 0' => rand(- PHP_INT_MAX, 1),
			'zero as integer' => 0,
			'any integer greater than 0' => rand(1, PHP_INT_MAX),
			'any float less than 0' => (float) - rand(1, PHP_INT_MAX),
			'- pi' => - M_PI,
			'0 as float' => 0.,
			'pi' => M_PI,
			'any float greater than 0' => (float) rand(1, PHP_INT_MAX),
			'any "string" less than 0' => (string) rand(1, PHP_INT_MAX),
			'- pi as string' => (string) - M_PI,
			'0 as string' => (string) 0.,
			'pi as string' => (string) M_PI,
			'any "string" greater than 0' => (string) (float) rand(1, PHP_INT_MAX),
			'binary number' => 0b11111111, // 255
			'hexadecimal number' => 0x1A, // 26,
			'octal number' => 0123 // 83
		];
	}

	protected function invalidValueDataProvider()
	{
		return [
			'true '=> true,
			'false' => false,
			'empty string' => '',
			'any string' => 'x' . uniqid(),
			'null' => null,
			'array' => [ [] ],
			'object' => new \stdclass,
		];
	}
}

namespace estvoyage\value\tests\units\float;

class testedClass extends \estvoyage\value\float
{
}
