install: # команда полезна при первом клонировании репозитория (или после удаления зависимостей)
	composer install
	
gendiff:
	./bin/gendiff tests/fixtures/file1.json tests/fixtures/file2.json
	
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
