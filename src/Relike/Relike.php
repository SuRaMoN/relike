<?php

namespace Relike;

use Relike\MatchAdapters\AutoMatchAdapterFactory;
use Relike\MatchAdapters\MatchAdapterFactory;
use Relike\ReParts\NamedGroup;
use Relike\ReParts\RePart;
use Relike\ReParts\Repeat;
use Relike\ReParts\Sequence;
use Relike\SearchAlgorithms\DefaultSearchAlgorithm;


class Relike
{
	protected $searchAlgorithm;
	protected $matchAdapterFactory;

	public function __construct(MatchAdapterFactory $matchAdapterFactory = null)
	{
		$this->searchAlgorithm = new DefaultSearchAlgorithm();
		if(null === $matchAdapterFactory) {
			$matchAdapterFactory = $this->getDefaultMatchAdapterFactory();
		}
		$this->matchAdapterFactory = $matchAdapterFactory;
	}

	protected function getDefaultMatchAdapterFactory()
	{
		return new AutoMatchAdapterFactory();
	}

	public function findAll($haystack, RePart $query, $offset = 0)
	{
		$haystack = $this->matchAdapterFactory->newInstance($haystack);
		return $this->searchAlgorithm->findAll($haystack, $query, $offset);
	}

	public function find($haystack, RePart $query, $offset = 0)
	{
		$match = $this->tryFind($haystack, $query, $offset);
		if(null === $match) {
			throw new NoMatchFoundException('No Match found for you query');
		}
		return $match;
	}

	public function tryFind($haystack, RePart $query, $offset = 0)
	{
		$haystack = $this->matchAdapterFactory->newInstance($haystack);
		return $this->searchAlgorithm->tryFind($haystack, $query, $offset);
	}

	public function findOffset($haystack, RePart $query, $offset = 0)
	{
		$haystack = $this->matchAdapterFactory->newInstance($haystack);
		return $this->searchAlgorithm->findOffset($haystack, $query, $offset);
	}

	public function findAllOffsets($haystack, RePart $query, $offset = 0)
	{
		$haystack = $this->matchAdapterFactory->newInstance($haystack);
		return $this->searchAlgorithm->findAllOffsets($haystack, $query, $offset);
	}

	public function sequence()
	{
		$args = func_get_args();
		return new Sequence(Sequence::arrayToReParts($args));
	}

	public function multiple()
	{
		$args = func_get_args();
		return new Repeat(Sequence::toRePart($args), 0, INF);
	}

	public function oneOrMore()
	{
		$args = func_get_args();
		return new Repeat(Sequence::toRePart($args), 1, INF);
	}

	public function optional()
	{
		$args = func_get_args();
		return new Repeat(Sequence::toRePart($args), 0, 1);
	}

	public function named($name)
	{
		$args = func_get_args();
		return new NamedGroup($name, Sequence::arrayToReParts(array_slice($args, 1)));
	}

	public function repeat($needle, $minRepeats, $maxRepeats = INF)
	{
		return new Repeat(Singleton::toRePart($needle), $minRepeats, $maxRepeats);
	}
}

