<?php

namespace estvoyage\value;

abstract class generic
{
	private
		$value
	;

	function __get($property)
	{
		return $this->value;
	}

	function __set($property, $value)
	{
		throw new \logicException(get_class($this) . ' is immutable');
	}

	function __unset($property)
	{
		throw new \logicException(get_class($this) . ' is immutable');
	}

	protected function __construct($value)
	{
		$this->value = $value;
	}
}
