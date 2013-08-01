<?php

namespace Relike\SearchAlgorithms;

use Relike\Relike;
use PHPUnit_Framework_TestCase;


class DefaultSearchAlgorithmTest extends PHPUnit_Framework_TestCase
{
	/** @test */
	public function testSequenceSearches()
	{
		$s = new Relike();
		$this->assertEquals(2, $s->findOffset('hello this is a test', $s->sequence('l', 'l', 'o')));
		$this->assertEquals(array(2, 24), $s->findAllOffsets('hello this is a test, hello', $s->sequence('l', 'l', 'o')));
	}

	/** @test */
	public function testMultipleSearches()
	{
		$s = new Relike();
		$this->assertEquals(0, $s->findOffset('hello this is a test', $s->multiple('l')));
		$this->assertEquals(range(0, 5), $s->findAllOffsets('azerty', $s->multiple('l')));
	}

	/** @test */
	public function testOneOrMoreSearches()
	{
		$s = new Relike();
		$this->assertEquals(2, $s->findOffset('hello this is a test', $s->oneOrMore('l')));
		$this->assertEquals(array(2), $s->findAllOffsets('hallo', $s->oneOrMore('l')));
	}
}

