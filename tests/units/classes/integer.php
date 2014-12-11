<?php

namespace estvoyage\value\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\value\tests\units
;

class integer extends units\test
{
	function beforeTestMethod($method)
	{
		ini_set('precision', 14); // default value in the php.ini
	}

	function testClass()
	{
		$this->testedClass
			->isAbstract
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
				->integer($integer->asInteger)->isEqualTo((int) $value)
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

	/**
	 * @dataProvider validValueProvider
	 */
	function testProperties($value)
	{
		$this
			->if(
				$integer = new integer\testedClass($value)
			)
			->then
				->boolean(isset($integer->asInteger))->isTrue
				->boolean(isset($integer->{uniqid()}))->isFalse
				->exception(function() use ($integer, & $property) { $integer->{$property = uniqid()}; })
					->isInstanceOf('logicException')
					->hasMessage('Undefined property: ' . get_class($integer) . '::' . $property)
		;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testEquality($value)
	{
		$this
			->boolean(new integer\testedClass($value) == new integer\testedClass($value))->isTrue
			->boolean(new integer\testedClass($value) == new integer\testedClass(PHP_INT_MAX))->isFalse
		;
	}

	protected function validValueProvider()
	{
		return [
			'any integer less than zero' => - rand(1, PHP_INT_MAX - 1),
			'0 as integer' => 0,
			'any integer greater than zero' => rand(1, PHP_INT_MAX - 1),
			'any "string" less than zero' => (string) - rand(1, PHP_INT_MAX - 1),
			'0 as string' => '0',
			'any "string" greater than zero' => (string) rand(1, PHP_INT_MAX - 1),
			'any "float" less than zero' => (float) - rand(1, PHP_INT_MAX - 1),
			'0 as float' => 0.,
			'any "float" greater than zero' => (float) rand(1, PHP_INT_MAX - 1),
			'binary number' => 0b11111111, // 255
			'hexadecimal number' => 0x1A, // 26,
			'octal number' => 0123, // 83
			'float which is an integer regarding to precision' => 1.00000000000000001
		];
	}

	protected function invalidValueProvider()
	{
		return [
			'true' => true,
			'false' => false,
			'empty string' => '',
			'any string' => 'a' . uniqid(),
			'null' => null,
			'array' => [ [] ],
			'object' => new \stdclass,
			'pi' => M_PI,
			'- pi' => - M_PI,
			'float with less than precision digits after comma' => 1.000000000000001
		];
	}
}

namespace estvoyage\value\tests\units\integer;

class testedClass extends \estvoyage\value\integer
{
}
