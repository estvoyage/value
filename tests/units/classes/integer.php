<?php

namespace estvoyage\value\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\value\tests\units
;

class integer extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isAbstract
			->extends('estvoyage\value\generic')
		;
	}

	function testConstructorWithNoArgument()
	{
		$this
			->if(
				$integer = new integer\testedClass
			)
			->then
				->integer($integer->asInteger)->isZero
				->castToString($integer)->isEqualTo('0')
		;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testConstructorWithValidValue($value)
	{
		$this
			->if(
				$integer = new integer\testedClass($value)
			)
			->then
				->integer($integer->asInteger)->isEqualTo($value)
				->castToString($integer)->isEqualTo($value)
		;
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	function testConstructorWithInvalidValue($value)
	{
		$this
			->exception(function() use ($value) { new integer\testedClass($value); })
				->isInstanceOf('domainException')
				->hasMessage('Value should be an integer')
		;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testValidateWithValidValue($value)
	{
		$this->boolean(integer\testedClass::validate($value))->isTrue;
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	function testValidateWithInvalidValue($value)
	{
		$this->boolean(integer\testedClass::validate($value))->isFalse;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testImmutability($value)
	{
		$this
			->if(
				$integer = new integer\testedClass($value)
			)
			->then
				->exception(function() use ($integer) { $integer->asInteger = uniqid(); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($integer) . ' is immutable')

				->exception(function() use ($integer) { $integer->{uniqid()} = uniqid(); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($integer) . ' is immutable')

				->exception(function() use ($integer) { unset($integer->asInteger); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($integer) . ' is immutable')

				->exception(function() use ($integer) { unset($integer->{uniqid()}); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($integer) . ' is immutable')
		;
	}

	function testPropertiesAvailability()
	{
		$this
			->if(
				$integer = new integer\testedClass
			)
			->then
				->boolean(isset($integer->asInteger))->isTrue
				->boolean(isset($integer->{uniqid()}))->isFalse
				->exception(function() use ($integer, & $property) { $integer->{$property = uniqid()}; })
					->isInstanceOf('logicException')
					->hasMessage('Undefined property in ' . get_class($integer) . ': ' . $property)
		;
	}

	protected function validValueProvider()
	{
		return [
			'any integer less than zero' => rand(- PHP_INT_MAX, -1),
			'zero as integer' => 0,
			'any integer greater than zero' => rand(1, PHP_INT_MAX)
		];
	}

	protected function invalidValueProvider()
	{
		return [
			'true' => true,
			'false' => false,
			'empty string' => '',
			'any string' => uniqid(),
			'null' => null,
			'array' => [ [] ],
			'object' => new \stdclass,
			'any integer casted to string' => (string) rand(- PHP_INT_MAX, PHP_INT_MAX),
			'0 casted to string' => (string) 0,
			'integer greater than 0 casted to string' => (string) rand(1, PHP_INT_MAX),
			'any float casted to string' => (string) (float) rand(- PHP_INT_MAX, PHP_INT_MAX),
			'0. casted to string' => (string) 0.,
			'any float greater than 0 casted to string' => (string) (float) rand(1, PHP_INT_MAX)
		];
	}
}

namespace estvoyage\value\tests\units\integer;

class testedClass extends \estvoyage\value\integer
{
}
