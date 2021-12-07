start: # démarrre les doker
	docker-compose -f docker-compose.yml up -d

stop: # arrête les dockers
	docker-compose -f docker-compose.yml down

build: # construit les images docker /!\ problème de droit à creuser
	docker-compose -f docker-compose.yml up -d --build
