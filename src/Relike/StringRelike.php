<?php

namespace Relike;

use Relike\MatchAdapters\MatchAdapterByNameFactory;


class StringRelike extends Relike
{
	protected function getDefaultMatchAdapterFactory()
	{
		return new MatchAdapterByNameFactory('string');
	}
}

