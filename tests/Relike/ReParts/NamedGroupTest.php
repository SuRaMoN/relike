<?php

namespace Relike\ReParts;

use PHPUnit_Framework_TestCase;
use Relike\StringRelike;


class NamedGroupTest extends PHPUnit_Framework_TestCase
{
	/** @test */
	public function testNamedGroup()
	{
		$s = new StringReLike();
		$match = $s->find('hallo', $s->sequence('a', $s->named('secondCharacter', 'l'), 'l'));
		$this->assertEquals('l', $match->getNamedGroup('secondCharacter')->getMatch());
	}
}

