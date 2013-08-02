<?php

namespace Relike;

use Relike\MatchAdapters\MatchAdapterByNameFactory;


class TokenArrayRelike extends Relike
{
	protected function getDefaultMatchAdapterFactory()
	{
		return new MatchAdapterByNameFactory('tokenarray');
	}
}

