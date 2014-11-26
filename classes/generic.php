<?php

namespace estvoyage\value;

abstract class generic
{
	use immutable;

	private
		$value
	;

	function __get($property)
	{
		return $this->value;
	}

	function __isset($property)
	{
		return true;
	}

	protected function __construct($value)
	{
		$this->value = $value;
	}
}
