<?php

namespace Relike\MatchAdapters;

use Relike\TokenArrayRelike;
use PHPUnit_Framework_TestCase;


class TokenArrayAdapterTest extends PHPUnit_Framework_TestCase
{
	/** @test */
	public function testSequenceSearches()
	{
		$tokens = token_get_all(file_get_contents(__FILE__));
		$s = new TokenArrayRelike();
		$needle = $s->sequence(T_NAMESPACE, $s->multiple(T_WHITESPACE), $s->optional(T_NS_SEPARATOR), $s->multiple(T_STRING, T_NS_SEPARATOR), T_STRING);
		$matchResult = $s->tryFind($tokens, $needle);
		$this->assertEquals(5, count($matchResult->getMatch()));
	}

	/** @test */
	public function testMatchingContent()
	{
		$tokens = token_get_all(file_get_contents(__FILE__));
		$s = new TokenArrayRelike();
		$needle = $s->sequence('testMatchingContent');
		$this->assertCount(1, $s->findAll($tokens, $needle));
	}
}

