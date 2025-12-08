PROJECT_NAME ?= multimod
DOCKER_COMPOSE ?= docker compose -f docker-compose.prod.yml
PHP_SERVICE ?= php
NGINX_SERVICE ?= nginx

.PHONY: help
help:
	@echo "Commandes disponibles :"
	@grep -E '^[a-zA-Z_-]+:.*?## ' Makefile | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

.PHONY: build
build:
	$(DOCKER_COMPOSE) build

.PHONY: up
up:
	$(DOCKER_COMPOSE) up -d

.PHONY: down
down:
	$(DOCKER_COMPOSE) down

.PHONY: restart
restart: down up

.PHONY: ps
ps:
	$(DOCKER_COMPOSE) ps

.PHONY: logs
logs:
	$(DOCKER_COMPOSE) logs -f

.PHONY: logs-php
logs-php:
	$(DOCKER_COMPOSE) logs -f $(PHP_SERVICE)

.PHONY: logs-nginx
logs-nginx:
	$(DOCKER_COMPOSE) logs -f $(NGINX_SERVICE)

.PHONY: pull
pull:
	git pull --ff-only

.PHONY: composer-install
composer-install:
	$(DOCKER_COMPOSE) exec -u root $(PHP_SERVICE) git config --system --add safe.directory /var/www/symfony || true
	$(DOCKER_COMPOSE) exec -u root $(PHP_SERVICE) sh -c "APP_ENV=prod composer install --no-dev --optimize-autoloader"

.PHONY: assets-build
assets-build:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) bin/console asset-map:compile

.PHONY: deploy
deploy: pull build up composer-install assets-build
	@echo "Déploiement terminé pour $(PROJECT_NAME)"
