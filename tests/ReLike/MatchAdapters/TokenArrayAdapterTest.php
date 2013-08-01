<?php

namespace Relike\MatchAdapters;

use Relike\Relike;
use PHPUnit_Framework_TestCase;


class TokenArrayAdapterTest extends PHPUnit_Framework_TestCase
{
	/** @test */
	public function testSequenceSearches()
	{
		$tokens = token_get_all(file_get_contents(__FILE__));
		$s = new Relike(new MatchAdapterByNameFactory('tokenarray'));
		$needle = $s->sequence(T_NAMESPACE, $s->multiple(T_WHITESPACE), $s->optional(T_NS_SEPARATOR), $s->multiple(T_STRING, T_NS_SEPARATOR), T_STRING);
		$matchResult = $s->tryFind($tokens, $needle);
		$this->assertEquals(5, count($matchResult->getMatch()));
	}
}

