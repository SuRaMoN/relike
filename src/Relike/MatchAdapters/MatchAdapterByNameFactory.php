<?php

namespace Relike\MatchAdapters;

use Relike\Exceptions\NoAdapterAvailableException;


class MatchAdapterByNameFactory implements MatchAdapterFactory
{
	protected $name;

	public function __construct($name)
	{
		$this->name = $name;
	}

	public function newInstance($haystack)
	{
		switch($this->name) {
			case $haystack instanceof MatchAdapter:
				return $haystack;
			case 'string':
				return new StringAdapter($haystack);
			case 'array':
				return new ArrayAdapter($haystack);
			case 'tokenarray':
				return new TokenArrayAdapter($haystack);
			default:
				throw new NoAdapterAvailableException("Can't find a suitable adapter for argument '" . get_class($haystack) . "'. Acccepted types are: string.");
		}
	}
}
 
