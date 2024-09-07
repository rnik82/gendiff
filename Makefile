install: # команда полезна при первом клонировании репозитория (или после удаления зависимостей)
	composer install
	
gendiff-json:
	./bin/gendiff tests/fixtures/before.json tests/fixtures/after.json

gendiff-yaml:
	./bin/gendiff tests/fixtures/before.yaml tests/fixtures/after.yaml
	
 validate: # проверяет файл composer.json на ошибки
	composer validate

lint: # проверка кода на соответствие стандартам
	composer exec --verbose phpcs -- --standard=PSR12 src bin

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 src tests

test:
	composer exec --verbose phpunit tests

test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

test-coverage-text:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-text

#.PHONY:
