<?php

namespace estvoyage\value\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\value\tests\units
;

class string extends units\test
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
				$string = new string\testedClass
			)
			->then
				->string($string->asString)->isEmpty
				->castToString($string)->isEmpty
		;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testConstructorWithValidValue($value)
	{
		$this
			->if(
				$string = new string\testedClass($value)
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
			->exception(function() use ($value) { new string\testedClass($value); })
				->isInstanceOf('domainException')
				->hasMessage('Value should be a string')
		;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testValidateWithValidValue($value)
	{
		$this->boolean(string\testedClass::validate($value))->isTrue;
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	function testValidateWithInvalidValue($value)
	{
		$this->boolean(string\testedClass::validate($value))->isFalse;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testImmutability($value)
	{
		$this
			->if(
				$string = new string\testedClass($value)
			)
			->then
				->exception(function() use ($string) { $string->asString = uniqid(); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($string) . ' is immutable')

				->exception(function() use ($string) { $string->{uniqid()} = uniqid(); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($string) . ' is immutable')

				->exception(function() use ($string) { unset($string->asString); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($string) . ' is immutable')

				->exception(function() use ($string) { unset($string->{uniqid()}); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($string) . ' is immutable')
		;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testEquality($value)
	{
		$this
			->boolean(new string\testedClass($value) == new string\testedClass($value))->isTrue
			->boolean(new string\testedClass($value) == new string\testedClass(uniqid()))->isFalse
		;
	}

	function testProperties()
	{
		$this
			->if(
				$string = new string\testedClass
			)
			->then
				->boolean(isset($string->asString))->isTrue
				->boolean(isset($string->{uniqid()}))->isFalse
				->exception(function() use ($string, & $property) { $string->{$property = uniqid()}; })
					->isInstanceOf('logicException')
					->hasMessage('Undefined property: ' . get_class($string) . '::' . $property)
		;
	}

	protected function validValueProvider()
	{
		return [
			'',
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
			new \stdclass
		];
	}
}

namespace estvoyage\value\tests\units\string;

class testedClass extends \estvoyage\value\string
{
}
