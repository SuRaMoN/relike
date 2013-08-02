<?php

spl_autoload_register(function ($className) {
	$availableClasses = array(
		'Relike\Relike',
		'Relike\TokenArrayRelike',
		'Relike\MatchResult',

		'Relike\MatchAdapters\MatchAdapter',
		'Relike\MatchAdapters\StringAdapter',
		'Relike\MatchAdapters\ArrayAdapter',
		'Relike\MatchAdapters\TokenArrayAdapter',
		'Relike\MatchAdapters\AutoMatchAdapterFactory',
		'Relike\MatchAdapters\MatchAdapterByNameFactory',
		'Relike\MatchAdapters\MatchAdapterFactory',

		'Relike\ReParts\RePart',
		'Relike\ReParts\Repeat',
		'Relike\ReParts\Sequence',
		'Relike\ReParts\Singleton',

		'Relike\SearchAlgorithms\SearchAlgorithm',
		'Relike\SearchAlgorithms\DefaultSearchAlgorithm',

		'Relike\Exceptions\NoAdapterAvailableException',
		'Relike\Exceptions\UnknownRePartException',
	);
	if(in_array($className, $availableClasses)) {
		require(__DIR__ . '/../' . strtr($className, '\\', '/') . '.php');
	}
});

