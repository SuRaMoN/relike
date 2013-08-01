<?php

namespace Relike\MatchAdapters;


class ArrayAdapter implements MatchAdapter
{
	protected $array;

	public function __construct($array)
	{
		$this->array = $array;
	}

	public function equals($identifier, $object)
	{
		return $identifier == $object;
	}

	public function nth($i)
	{
		return $this->array[$i];
	}

	public function slice($offset, $length)
	{
		return array_slice($this->array, $offset, $length);
	}

	public function count()
	{
		return count($this->array);
	}
}

 
