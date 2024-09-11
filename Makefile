install: # команда полезна при первом клонировании репозитория (или после удаления зависимостей)
	composer install

update: # обновить зависимости
	composer update
	
gendiff-json-stylish:
	./bin/gendiff tests/fixtures/before.json tests/fixtures/after.json

gendiff-yaml-stylish:
	./bin/gendiff tests/fixtures/before.yaml tests/fixtures/after.yaml

gendiff-json-plain:
	./bin/gendiff tests/fixtures/before.json tests/fixtures/after.json --format plain

gendiff-yaml-plain:
	./bin/gendiff tests/fixtures/before.yaml tests/fixtures/after.yaml --format plain
	
 validate: # проверяет файл composer.json на ошибки
	composer validate

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src tests
	composer exec --verbose phpstan

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 src tests

test:
	composer exec --verbose phpunit tests

test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

test-coverage-text:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-text

#.PHONY: tests
