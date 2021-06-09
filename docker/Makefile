SHELL=/bin/bash -e

.DEFAULT_GOAL := help

help:
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

env:
	cp .env.docker.example .env

build:
	@docker-compose build php-fpm
	@docker-compose build nginx
	@docker-compose build postgres
	@docker-compose build cassandra
	@docker-compose build elasticsearch
	@docker-compose build kibana
	@docker-compose build grafana
	@docker-compose build sonarqube
	@docker-compose build kafka
	@docker-compose build kafka-manager

clean:
	@docker system prune --volumes --force

up:
	docker-compose up -d
down:
	@docker-compose down
bash:
	@docker-compose exec workspace bash
restart: down up
replica:
	@docker-compose exec postgres /var/lib/postgresql/config/replica.sh
	@docker-compose up -d postgres
	@docker-compose exec pg-slave1 /var/lib/postgresql/config/replica.sh

phpstan:
	@docker-compose exec workspace /var/www/vendor/bin/phpstan analyse
insights:
	@docker-compose exec workspace php artisan insights

