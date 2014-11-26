<?php

namespace estvoyage\value;

trait immutable
{
	function __set($property, $value)
	{
		throw new \logicException(get_class($this) . ' is immutable');
	}

	function __unset($property)
	{
		throw new \logicException(get_class($this) . ' is immutable');
	}

	abstract function __get($property);
	abstract function __isset($property);
}
