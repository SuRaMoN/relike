<?php

namespace Relike\ReParts;


class Sequence implements RePart
{
	protected $sequence;

	public function __construct(array $sequence)
	{
		$this->sequence = $sequence;
	}
 
	public function getSequence()
	{
		return $this->sequence;
	}

	public static function arrayToReParts(array $sequence)
	{
		foreach($sequence as &$needle) {
			$needle = Singleton::toRePart($needle);
		}
		return $sequence;
	}

	public static function toRePart(array $sequence)
	{
		$sequence = self::arrayToReParts($sequence);
		if(count($sequence) == 1) {
			return $sequence[0];
		}
		return new self($sequence);
	}
}

