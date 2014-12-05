<?php

namespace estvoyage\value\world;

trait generic
{
	use immutable;

	private function init(array $values)
	{
		$this->values = $values;
	}
}
