start: # démarrre les doker
	docker-compose -f docker-compose.yml up -d

stop: # arrête les dockers
	docker-compose -f docker-compose.yml down

build: # construit les images docker /!\ problème de droit à creuser
	docker-compose -f docker-compose.yml up -d --build

clean: # clean le code
	docker exec -it airtable_php vendor/bin/php-cs-fixer fix
	docker exec -it airtable_php php -d memory_limit=2G vendor/bin/phpstan analyse src tests
	docker exec -it airtable_php vendor/bin/rector process

test: # lance les tests PHP /!\ xdebug à installer en mode docker
	docker exec -it airtable_php vendor/bin/phpunit --coverage-html coverage
