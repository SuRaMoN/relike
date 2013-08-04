ReLike
======

ReLike is an object orientated rewrite of regular expressions. But it's designed to not only cope with strings. It can handle arrays, strings and token arrays (future development will add support for html, trees, xml etc).

[![Build Status](https://travis-ci.org/SuRaMoN/relike.png?branch=master)](https://travis-ci.org/SuRaMoN/relike)

Examples
========
Simple string search:

    $s = new \Relike\StringRelike();
    $needle = $s->sequence('e', $s->repeat('l', 2, 2), 'o');
    echo $s->find('Hello world!', $needle)->getMatch(); # will output "ello"

Search in php source tokens:

    $s = new \Relike\TokenArrayRelike();
    $haystack = token_get_all('<?php use I\Iz\A\Namespace;');
    $needle = $s->sequence(
			T_NAMESPACE, $s->multiple(T_WHITESPACE),
			$s->named('name', $s->optional(T_NS_SEPARATOR), $s->multiple(T_STRING, T_NS_SEPARATOR), T_STRING)
		);
	echo $s->find($haystack, $needle)->getNamedGroup('name')->getMatch(); # will output the tokens for "I\Iz\A\Namespace"

Install Guide
============

1. Download ReLike (you can [download](https://github.com/SuRaMoN/relike/archive/master.zip) directly from github, or clone it with git: `git clone https://github.com/SuRaMoN/relike.git`, or use [composer](http://getcomposer.org/))
2. Include the autoload header located in src/autload.php (eg: `require('relike/src/autload.php');`) or you can use [psr-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
3. Learn and use itertools by looking at the [examples](https://github.com/SuRaMoN/relike), [tests](https://github.com/SuRaMoN/relike/tree/master/tests/Relike) and [source code](https://github.com/SuRaMoN/relike/tree/master/src/Relike)

