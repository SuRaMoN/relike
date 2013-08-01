<?php

namespace Relike\MatchAdapters;

use Relike\Exceptions\NoAdapterAvailableException;


class AutoMatchAdapterFactory implements MatchAdapterFactory
{
	public function __construct()
	{
	}

	public function newInstance($haystack)
	{
		switch(true) {
			case $haystack instanceof MatchAdapter:
				return $haystack;
			case is_string($haystack):
				return new StringAdapter($haystack);
			case is_array($haystack):
				return new ArrayAdapter($haystack);
			default:
				throw new NoAdapterAvailableException("Can't find a suitable adapter for argument '" . get_class($haystack) . "'. Acccepted types are: string.");
		}
	}
}
 
