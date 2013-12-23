
.PHONY: relike tests

relike:
	bin/composer.phar update

tests:
	phpunit

