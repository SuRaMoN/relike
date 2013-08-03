<?php

namespace Relike\SearchAlgorithms;

use Relike\Exceptions\UnknownRePartException;
use Relike\MatchAdapters\MatchAdapter;
use Relike\MatchResult;
use Relike\ReParts\NamedGroup;
use Relike\ReParts\RePart;
use Relike\ReParts\Repeat;
use Relike\ReParts\Sequence;
use Relike\ReParts\Singleton;


class DefaultSearchAlgorithm extends SearchAlgorithm
{
	public function tryFind(MatchAdapter $haystack, RePart $query, $offset)
	{
		$matchLength = self::NO_MATCH;
		$matchOffset = $offset;
		$count = $haystack->count();

		while($matchOffset < $count) {
			list($matchLength, $namedGroups) = $this->getMatchLength($haystack, $query, $matchOffset);
			if(self::NO_MATCH != $matchLength) {
				break;
			}
			$matchOffset += 1;
		}

		if(self::NO_MATCH == $matchLength) {
			return null;
		}

		return new MatchResult($matchOffset, $matchLength, $haystack->slice($matchOffset, $matchLength), $namedGroups);
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
			case $query instanceof NamedGroup:
				return $this->getMatchLengthNamedGroup($haystack, $query, $offset);
			default:
				throw new UnknownRePartException("Unknown RePart in query: " . get_class($query));
		}
	}

	protected function getMatchLengthSequence(MatchAdapter $haystack, Sequence $sequence, $offset)
	{
		$namedGroups = array();
		$count = $haystack->count();
		$startOffset = $offset;
		foreach($sequence->getSequence() as $identifier) {
			if($offset > $count) {
				return self::NO_MATCH;
			}
			list($matchLength, $subNamedGroups) = $this->getMatchLength($haystack, $identifier, $offset);
			if(self::NO_MATCH == $matchLength) {
				return array(self::NO_MATCH, null);
			}
			$offset += $matchLength;
			$namedGroups = array_merge($namedGroups, $subNamedGroups);
		}
		return array($offset - $startOffset, $namedGroups);
	}

	protected function getMatchLengthSingleton(MatchAdapter $haystack, Singleton $sequence, $offset)
	{
		$count = $haystack->count();
		if($offset >= $count || !$haystack->equals($sequence->getNeedle(), $haystack->nth($offset))) {
			return array(self::NO_MATCH, null);
		}
		return array(1, array());
	}

	protected function getMatchLengthRepeat(MatchAdapter $haystack, Repeat $repeat, $offset)
	{
		$namedGroups = array();
		$count = $haystack->count();
		$startOffset = $offset;
		$numRepeats = 0;
		while($offset <= $count && $numRepeats < $repeat->getMaxRepeats()) {
			list($matchLength, $subNamedGroups) = $this->getMatchLength($haystack, $repeat->getNeedle(), $offset);
			if(self::NO_MATCH == $matchLength) {
				break;
			}
			$numRepeats += 1;
			$offset += $matchLength;
			$namedGroups = array_merge($namedGroups, $subNamedGroups);
		}
		$matchLength = $numRepeats < $repeat->getMinRepeats() ? self::NO_MATCH : $offset - $startOffset;
		return array($matchLength, $namedGroups);
	}

	protected function getMatchLengthNamedGroup(MatchAdapter $haystack, NamedGroup $namedGroup, $offset)
	{
		$namedGroups = array();
		list($matchLength, $subNamedGroups) = $this->getMatchLength($haystack, new Sequence($namedGroup->getSequence()), $offset);
		if(self::NO_MATCH != $matchLength) {
			$namedGroups[$namedGroup->getName()] = new MatchResult($offset, $matchLength, $haystack->slice($offset, $matchLength));
		}
		return array($matchLength, $namedGroups);
	}
}

