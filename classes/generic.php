<?php

namespace estvoyage\value;

abstract class generic
{
	use immutable;

	protected function __construct(array $values)
	{
		$this->values = $values;
	}
}
