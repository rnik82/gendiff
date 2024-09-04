install: # команда полезна при первом клонировании репозитория (или после удаления зависимостей)
	composer install
	
gendiff:
	./bin/gendiff tests/files/file1.json tests/files/file2.json
	
 validate: # проверяет файл composer.json на ошибки
	composer validate
	
lint: # проверка кода на соответствие стандартам
	composer exec --verbose phpcs -- --standard=PSR12 src bin



#.PHONY:
