<?php

namespace Relike\ReParts;


class Singleton implements RePart
{
	protected $needle;

	public function __construct($needle)
	{
		$this->needle = $needle;
	}
 
	public function getNeedle()
	{
		return $this->needle;
	}

	public static function toRePart($needle)
	{
		return $needle instanceof RePart ? $needle : new self($needle);
	}
}

