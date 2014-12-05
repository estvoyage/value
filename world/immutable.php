<?php

namespace estvoyage\value\world;

trait immutable
{
	private
		$values
	;

	function __get($property)
	{
		if (! isset($this->{$property}))
		{
			throw new \logicException('Undefined property: ' . get_class($this) . '::' . $property);
		}

		return $this->values[$property];
	}

	function __set($property, $value)
	{
		throw new \logicException(get_class($this) . ' is immutable');
	}

	function __unset($property)
	{
		throw new \logicException(get_class($this) . ' is immutable');
	}

	function __isset($property)
	{
		/*
		isset() is very fast but can fail if $this->values[$property] === null
		so using array_key_exists as fallback to be sure that the key does not exist
		is a good trade-off between reliability and performance
		*/
		return isset($this->values[$property]) || array_key_exists($property, $this->values);
	}
}
