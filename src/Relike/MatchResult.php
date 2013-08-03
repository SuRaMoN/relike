<?php

namespace Relike;


class MatchResult
{
	protected $offset;
	protected $length;
	protected $match;
	protected $namedGroups;

	public function __construct($offset, $length, $match, $namedGroups = array())
	{
		$this->offset = $offset;
		$this->length = $length;
		$this->match = $match;
		$this->namedGroups = $namedGroups;
	}

	public function getOffset()
	{
		return $this->offset;
	}

	public function getLength()
	{
		return $this->length;
	}

	public function getMatch()
	{
		return $this->match;
	}
 
 	public function getNamedGroup($id)
 	{
 		return $this->namedGroups[$id];
 	}

 	public function getNamedGroups()
 	{
 		return $this->namedGroups;
 	}
}

