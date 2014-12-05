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
		;
	}

	function testConstructorWithNoArgument()
	{
		$this
			->if(
				$unsigned = new unsigned\testedClass
			)
			->then
				->integer($unsigned->asInteger)->isZero
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
				->integer($unsigned->asInteger)->isEqualTo((int) $value)
				->castToString($unsigned)->isEqualTo((string) (int) $value)
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
				$unsigned = new unsigned\testedClass
			)
			->then
				->boolean(isset($unsigned->asInteger))->isTrue
				->boolean(isset($unsigned->{uniqid()}))->isFalse
				->exception(function() use ($unsigned, & $property) { $unsigned->{$property = uniqid()}; })
					->isInstanceOf('logicException')
					->hasMessage('Undefined property: ' . get_class($unsigned) . '::' . $property)
		;
	}

	protected function validValueProvider()
	{
		return [
			'0 as integer' => 0,
			'any integer between 1 and PHP_INT_MAX' => rand(1, PHP_INT_MAX),
			'0 as string' => '0',
			'any "string" between 1 and PHP_INT_MAX' => (string) rand(1, PHP_INT_MAX),
			'0 as float' => 0.,
			'any "float" between 1 and PHP_INT_MAX' => (float) rand(1, PHP_INT_MAX),
			'binary number' => 0b11111111, // 255
			'hexadecimal number' => 0x1A, // 26,
			'octal number' => 0123 // 83
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
			'any negative integer' => - rand(1, PHP_INT_MAX),
			'any negative "string"' => (string) - rand(1, PHP_INT_MAX),
			'any negative "float"' => (float) - rand(1, PHP_INT_MAX)
		];
	}
}

namespace estvoyage\value\tests\units\integer\unsigned;

class testedClass extends \estvoyage\value\integer\unsigned
{
}
