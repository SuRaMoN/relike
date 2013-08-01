<?php

namespace Relike\ReParts;


class Repeat implements RePart
{
	protected $needle;
	protected $minRepeats;
	protected $maxRepeats;

	public function __construct($needle, $minRepeats = 0, $maxRepeats = INF)
	{
		$this->needle = $needle instanceof RePart ? $needle : new Singleton($needle);
		$this->minRepeats = $minRepeats;
		$this->maxRepeats = $maxRepeats;
	}
 
	public function getNeedle()
	{
		return $this->needle;
	}

	public function getMinRepeats()
	{
		return $this->minRepeats;
	}

	public function getMaxRepeats()
	{
		return $this->maxRepeats;
	}
}

