<?php

spl_autoload_register(function ($className) {
	$availableClasses = array(
		'Relike\MatchResult',
		'Relike\Relike',
		'Relike\StringRelike',
		'Relike\TokenArrayRelike',

		'Relike\Exceptions\NoAdapterAvailableException',
		'Relike\Exceptions\NoMatchFoundException',
		'Relike\Exceptions\UnknownRePartException',

		'Relike\MatchAdapters\ArrayAdapter',
		'Relike\MatchAdapters\AutoMatchAdapterFactory',
		'Relike\MatchAdapters\MatchAdapter',
		'Relike\MatchAdapters\MatchAdapterByNameFactory',
		'Relike\MatchAdapters\MatchAdapterFactory',
		'Relike\MatchAdapters\StringAdapter',
		'Relike\MatchAdapters\TokenArrayAdapter',

		'Relike\ReParts\NamedGroup',
		'Relike\ReParts\RePart',
		'Relike\ReParts\Repeat',
		'Relike\ReParts\Sequence',
		'Relike\ReParts\Singleton',

		'Relike\SearchAlgorithms\DefaultSearchAlgorithm',
		'Relike\SearchAlgorithms\SearchAlgorithm',
	);
	if(in_array($className, $availableClasses)) {
		require(__DIR__ . '/../' . strtr($className, '\\', '/') . '.php');
	}
});

