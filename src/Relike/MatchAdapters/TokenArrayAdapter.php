<?php

namespace Relike\MatchAdapters;


class TokenArrayAdapter extends ArrayAdapter
{
	const TOKEN_INDEX = 0;
	const STRING_CONTENT = 1;
	const LINE_NUMBER = 2;

	public function equals($identifier, $object)
	{
		$object = is_string($object) ? $object : $object[self::TOKEN_INDEX];
		return $identifier == $object;
	}
}

 
