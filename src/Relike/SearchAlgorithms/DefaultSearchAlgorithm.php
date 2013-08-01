<?php

namespace Relike\SearchAlgorithms;

use Relike\ReParts\Singleton;
use Relike\MatchResult;
use Relike\ReParts\Repeat;
use Relike\Exceptions\UnknownRePartException;
use Relike\MatchAdapters\MatchAdapter;
use Relike\ReParts\Sequence;
use Relike\ReParts\RePart;


class DefaultSearchAlgorithm extends SearchAlgorithm
{
	public function tryFind(MatchAdapter $haystack, RePart $query, $offset)
	{
		$matchLength = self::NO_MATCH;
		$matchOffset = $offset;
		$count = $haystack->count();

		while($matchOffset < $count) {
			$matchLength = $this->getMatchLength($haystack, $query, $matchOffset);
			if(self::NO_MATCH != $matchLength) {
				break;
			}
			$matchOffset += 1;
		}

		if(self::NO_MATCH == $matchLength) {
			return null;
		}

		return new MatchResult($matchOffset, $matchLength, $haystack->slice($matchOffset, $matchLength));
	}

	protected function getMatchLength(MatchAdapter $haystack, RePart $query, $offset)
	{
		switch(true)
		{
			case $query instanceof Sequence:
				return $this->getMatchLengthSequence($haystack, $query, $offset);
			case $query instanceof Repeat:
				return $this->getMatchLengthRepeat($haystack, $query, $offset);
			case $query instanceof Singleton:
				return $this->getMatchLengthSingleton($haystack, $query, $offset);
			default:
				throw new UnknownRePartException("Unknown RePart in query: " . get_class($query));
		}
	}

	protected function getMatchLengthSequence(MatchAdapter $haystack, Sequence $sequence, $offset)
	{
		$count = $haystack->count();
		$startOffset = $offset;
		foreach($sequence->getSequence() as $identifier) {
			if($offset > $count) {
				return self::NO_MATCH;
			}
			$matchLength = $this->getMatchLength($haystack, $identifier, $offset);
			if(self::NO_MATCH == $matchLength) {
				return self::NO_MATCH;
			}
			$offset += $matchLength;
		}
		return $offset - $startOffset;
	}

	protected function getMatchLengthSingleton(MatchAdapter $haystack, Singleton $sequence, $offset)
	{
		$count = $haystack->count();
		if($offset >= $count || !$haystack->equals($sequence->getNeedle(), $haystack->nth($offset))) {
			return self::NO_MATCH;
		}
		return 1;
	}

	protected function getMatchLengthRepeat(MatchAdapter $haystack, Repeat $repeat, $offset)
	{
		$count = $haystack->count();
		$startOffset = $offset;
		$numRepeats = 0;
		while($offset <= $count && $numRepeats < $repeat->getMaxRepeats()) {
			$matchLength = $this->getMatchLength($haystack, $repeat->getNeedle(), $offset);
			if(self::NO_MATCH == $matchLength) {
				break;
			}
			$numRepeats += 1;
			$offset += $matchLength;
		}
		return $numRepeats < $repeat->getMinRepeats() ? self::NO_MATCH : $offset - $startOffset;
	}
}

