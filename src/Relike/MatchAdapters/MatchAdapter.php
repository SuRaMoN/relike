<?php

namespace Relike\MatchAdapters;


interface MatchAdapter
{
	public function equals($identifier, $object);
	public function nth($i);
	public function slice($offset, $length);
	public function count();
}

