<?php

namespace Relike\SearchAlgorithms;

use Relike\MatchAdapters\MatchAdapter;
use Relike\ReParts\RePart;


abstract class SearchAlgorithm
{
	const NO_MATCH = -1;

	abstract public function tryFind(MatchAdapter $haystack, RePart $query, $offset);

	public function __construct()
	{
	}

	public function findAllOffsets(MatchAdapter $haystack, RePart $query, $offset)
	{
		$offsets = array();
		while(true) {
			$matchResult = $this->tryFind($haystack, $query, $offset);
			if(null === $matchResult) {
				return $offsets;
			}
			$offsets[] = $matchResult->getOffset();
			$offset = $matchResult->getOffset() + max($matchResult->getLength(), 1);
		}
	}

	public function findOffset(MatchAdapter $haystack, RePart $query, $offset)
	{
		$matchResult = $this->tryFind($haystack, $query, $offset);
		if(null === $matchResult) {
			return self::NO_MATCH;
		}
		return $matchResult->getoffset();
	}
}

