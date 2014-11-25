<?php

namespace estvoyage\value\tests\units\integer;

require __DIR__ . '/../../runner.php';

use
	estvoyage\value\tests\units
;

class unsigned extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isAbstract
			->extends('estvoyage\value\generic')
			->extends('estvoyage\value\integer')
		;
	}

	function testConstructorWithNoArgument()
	{
		$this
			->if(
				$unsigned = new unsigned\testedClass()
			)
			->then
				->integer($unsigned->{uniqid()})->isZero
				->castToString($unsigned)->isEqualTo('0')
		;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testConstructorWithValidValue($value)
	{
		$this
			->if(
				$unsigned = new unsigned\testedClass($value)
			)
			->then
				->integer($unsigned->{uniqid()})->isEqualTo($value)
				->castToString($unsigned)->isEqualTo((string) $value)
		;
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	function testConstructorWithInvalidValue($value)
	{
		$this
			->exception(function() use ($value) { new unsigned\testedClass($value); })
				->isInstanceOf('domainException')
				->hasMessage('Value should be an integer greater than or equal to 0')
		;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testValidateWithValidValue($value)
	{
		$this->boolean(unsigned\testedClass::validate($value))->isTrue;
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	function testValidateWithInvalidValue($value)
	{
		$this->boolean(unsigned\testedClass::validate($value))->isFalse;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testImmutability($value)
	{
		$this
			->if(
				$integer = new unsigned\testedClass($value)
			)
			->then
				->exception(function() use ($integer) { $integer->value = uniqid(); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($integer) . ' is immutable')

				->exception(function() use ($integer) { $integer->{uniqid()} = uniqid(); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($integer) . ' is immutable')

				->exception(function() use ($integer) { unset($integer->value); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($integer) . ' is immutable')

				->exception(function() use ($integer) { unset($integer->{uniqid()}); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($integer) . ' is immutable')
		;
	}

	protected function validValueProvider()
	{
		return [
			'zero as integer' => 0,
			'any integer between 1 and PHP_INT_MAX' => rand(1, PHP_INT_MAX)
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

namespace estvoyage\value\tests\units\integer\unsigned;

class testedClass extends \estvoyage\value\integer\unsigned
{
}
