# *estvoyage\value* [![Build Status](https://travis-ci.org/estvoyage/value.svg?branch=master)](https://travis-ci.org/estvoyage/value) [![Coverage Status](https://coveralls.io/repos/estvoyage/value/badge.png)](https://coveralls.io/r/estvoyage/value)

## A set of whole value for PHP

Beside using the handful of primitive type offered by PHP (floats, integers, strings, boolean, datetime), you will make and use new objects that represent the meaningful quantities of your business.  
These values (like currency, credit card numbers, zip code, firstname, lastname, calendar period or telephone number) will carry whole, useful chunks of information from the user-interface to the domain model.  
But often in early stages of development you make decisions about representing simple facts using primitive type…  
And as development proceeds you realize that those simple items aren't so simple anymore: A telephone number may be represented as a string for a while, but later you realize that the telephone needs special behavior for formatting, extracting the area code, and the like.  
So it must be interesting to use object to quantify your domain model and use these values as the arguments of your methods very early.  

This set provide currently base classes for:

* string
* integer
* unsigned integer
* float
* unsigned float

All instances of these classes are [immutable](http://c2.com/cgi/wiki?ValueObjectsShouldBeImmutable), so if you try to set or unset one of their properties, a  `logicException` will be throwed.  
To access the underlying value, use property `asString` for `string`, `asInteger` for `integer` and `asFloat` for `float`.  
All of these classes are abstract, so you should extends them to quantify your domain:  

``` php
<?php

use estvoyage\value\string;

final class phone extends string
{
	function __construct($value)
	{
		parent::__construct($value);

		if (! static::validateFormat($value))
		{
			throw new \domainException('Phone number format is invalid');
		}
	}

	static function validate($value)
	{
		return parent::validate($value) && self::validateFormat($value);
	}

	private static function validateFormat($value)
	{
		return preg_match('/^\+\d{2} \d(?: \d{2}){4}$/', $value);
	}
}

$phone = new phone('+ 33 1 23 45 67 89');
echo $phone->asString; // display '+ 33 1 23 45 67 89'
echo $phone->{uniqid()}; // throw a \logicException with message 'Undefined property in phone: …'
$phone->{uniqid()} = uniqid(); // throw a \logicException with message 'phone is immutable'
$phone->asString = uniqid(); // throw a \logicException with message 'phone is immutable'
unset($phone->{uniqid()}); // throw a \logicException with message 'phone is immutable'
unset($phone->asString); // throw a \logicException with message 'phone is immutable'

$badFormat = new phone('01 23 45 67 89'); // throw a domainException!
```

Note that the `phone` class is final, because it contains a public property, so extend it will be a violation of the [Liskov substitution principle](http://en.wikipedia.org/wiki/Liskov_substitution_principle).  
All of these classes implements `__toString()` so you can use one of their instance as argument of any string related PHP function.  

``` php
<?php

use estvoyage\value\string;

final class phone extends string {}

$phone = new phone('+ 33 1 23 45 67 89');
echo substr($phone, 0, 4); // display '+ 33'
```
