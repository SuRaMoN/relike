<?php

namespace Relike\MatchAdapters;


interface MatchAdapterFactory
{
	public function newInstance($input);
}

