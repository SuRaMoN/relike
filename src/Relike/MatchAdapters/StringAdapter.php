<?php

namespace Relike\MatchAdapters;


class StringAdapter implements MatchAdapter
{
	protected $string;

	public function __construct($string)
	{
		$this->string = $string;
	}

	public function equals($identifier, $object)
	{
		return $identifier == $object;
	}

	public function nth($i)
	{
		return $this->string[$i];
	}

	public function slice($offset, $length)
	{
		return substr($this->string, $offset, $length);
	}

	public function count()
	{
		return strlen($this->string);
	}
}

 
