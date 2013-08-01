<?php

namespace Relike;


class MatchResult
{
	protected $offset;
	protected $length;
	protected $match;

	public function __construct($offset, $length, $match)
	{
		$this->offset = $offset;
		$this->length = $length;
		$this->match = $match;
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
}

