<?php

namespace estvoyage\value\tests\units\float;

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
			->extends('estvoyage\value\float')
		;
	}

	function testConstructorWithNoArgument()
	{
		$this
			->if(
				$unsigned = new unsigned\testedClass
			)
			->then
				->float($unsigned->asFloat)->isZero
				->castToString($unsigned)->isEqualTo('0.')
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
				->float($unsigned->asFloat)->isEqualTo($value)
				->castToString($unsigned)->isEqualTo((string) (float) $value)
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
				->hasMessage('Value should be a float greater than or equal to 0.')
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
				$unsigned = new unsigned\testedClass($value)
			)
			->then
				->exception(function() use ($unsigned) { $unsigned->asFloat = uniqid(); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($unsigned) . ' is immutable')

				->exception(function() use ($unsigned) { $unsigned->{uniqid()} = uniqid(); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($unsigned) . ' is immutable')

				->exception(function() use ($unsigned) { unset($unsigned->asFloat); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($unsigned) . ' is immutable')

				->exception(function() use ($unsigned) { unset($unsigned->{uniqid()}); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($unsigned) . ' is immutable')
		;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testProperties($value)
	{
		$this
			->if(
				$unsigned = new unsigned\testedClass
			)
			->then
				->boolean(isset($unsigned->asFloat))->isTrue
				->boolean(isset($unsigned->{uniqid()}))->isFalse
				->exception(function() use ($unsigned, & $property) { $unsigned->{$property = uniqid()}; })
					->isInstanceOf('logicException')
					->hasMessage('Undefined property: ' . get_class($unsigned) . '::' . $property)
		;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testEquality($value)
	{
		$this
			->boolean(new unsigned\testedClass($value) == new unsigned\testedClass($value))->isTrue
			->boolean(new unsigned\testedClass($value) == new unsigned\testedClass((float) rand(0, PHP_INT_MAX)))->isFalse
		;
	}

	protected function validValueProvider()
	{
		return [
			'zero as integer' => 0,
			'zero as float' => 0.,
			'any integer between 1 and PHP_INT_MAX' => rand(1, PHP_INT_MAX),
			'any float greater than 1.' => (float) rand(1, PHP_INT_MAX)
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

namespace estvoyage\value\tests\units\float\unsigned;

class testedClass extends \estvoyage\value\float\unsigned
{
}
