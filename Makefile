build: run shutdown composer npm asset

run:
	@bash -l -c 'docker-compose up -d'

shutdown:
	@bash -l -c 'docker-compose down'

composer:
	@docker exec -i kalitics-test composer install

npm:
	@docker exec -i kalitics-test npm install

asset:
	@docker exec -i kalitics-test npm run dev

database: db  db-migrate db-load-data

db:
	@docker exec -it kalitics-db sh -c "mysql -u root -pdb_password kalitics"

db-migrate:
	@docker exec -i kalitics-test php bin/console --env=dev doctrine:migrations:migrate --no-interaction

db-load-data:
	@docker exec -i kalitics-test php bin/console --env=dev doctrine:fixtures:load --no-interaction
