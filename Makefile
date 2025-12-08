PROJECT_NAME ?= multimod
DOCKER_COMPOSE_PROD ?= docker compose -f docker-compose.prod.yml
DOCKER_COMPOSE_DEV ?= docker compose -f docker-compose.yml
PHP_SERVICE ?= php
NGINX_SERVICE ?= nginx
DB_SERVICE ?= db

# Colors for output
COLOR_RESET = \033[0m
COLOR_INFO = \033[36m
COLOR_SUCCESS = \033[32m
COLOR_WARNING = \033[33m

##
## Help
##---------------------------------------------------------------------------

.DEFAULT_GOAL := help

.PHONY: help
help: ## Affiche cette aide
ifeq ($(OS),Windows_NT)
	@chcp 65001 > nul
	@echo Commandes disponibles pour $(PROJECT_NAME):
	@grep -E "^[a-zA-Z_-]+:.*## " Makefile | sort
else
	@echo "$(COLOR_INFO)Commandes disponibles pour $(PROJECT_NAME):$(COLOR_RESET)"
	@grep -E '^[a-zA-Z_-]+:.*?## ' Makefile | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  $(COLOR_SUCCESS)%-30s$(COLOR_RESET) %s\n", $$1, $$2}'
endif

##
## Installation locale (sans Docker)
##---------------------------------------------------------------------------

.PHONY: install
install: ## Installation complète du projet en local
	@echo "$(COLOR_INFO)Installation du projet $(PROJECT_NAME)...$(COLOR_RESET)"
	composer install
	@if [ ! -f .env.local ]; then \
		echo "$(COLOR_WARNING)Création du fichier .env.local...$(COLOR_RESET)"; \
		cp .env .env.local; \
		echo "$(COLOR_WARNING)⚠️  Pensez à configurer vos variables d'environnement dans .env.local$(COLOR_RESET)"; \
	fi
	@echo "$(COLOR_SUCCESS)✓ Installation terminée !$(COLOR_RESET)"
	@echo "$(COLOR_INFO)Prochaines étapes :$(COLOR_RESET)"
	@echo "  1. Configurez .env.local avec vos paramètres de base de données"
	@echo "  2. Exécutez 'make db-create' pour créer la base de données"
	@echo "  3. Exécutez 'make db-migrate' pour appliquer les migrations"
	@echo "  4. Lancez le serveur avec 'make serve'"

.PHONY: composer-install-local
composer-install-local: ## Installation des dépendances Composer (local)
	composer install

.PHONY: composer-update-local
composer-update-local: ## Mise à jour des dépendances Composer (local)
	composer update

##
## Base de données locale
##---------------------------------------------------------------------------

.PHONY: db-create
db-create: ## Créer la base de données (local)
	php bin/console doctrine:database:create --if-not-exists

.PHONY: db-drop
db-drop: ## Supprimer la base de données (local)
	php bin/console doctrine:database:drop --force --if-exists

.PHONY: db-migrate
db-migrate: ## Exécuter les migrations (local)
	php bin/console doctrine:migrations:migrate --no-interaction

.PHONY: db-migration-create
db-migration-create: ## Créer une nouvelle migration (local)
	php bin/console make:migration

.PHONY: db-fixtures
db-fixtures: ## Charger les fixtures (local)
	php bin/console doctrine:fixtures:load --no-interaction

.PHONY: db-reset
db-reset: db-drop db-create db-migrate ## Reset complet de la base de données (local)
	@echo "$(COLOR_SUCCESS)✓ Base de données réinitialisée !$(COLOR_RESET)"

##
## Cache local
##---------------------------------------------------------------------------

.PHONY: cache-clear
cache-clear: ## Vider le cache (local)
	php bin/console cache:clear

.PHONY: cache-warmup
cache-warmup: ## Préchauffer le cache (local)
	php bin/console cache:warmup

.PHONY: cache-clear-prod
cache-clear-prod: ## Vider le cache en mode production (local)
	APP_ENV=prod php bin/console cache:clear

.PHONY: cache-warmup-prod
cache-warmup-prod: ## Préchauffer le cache en mode production (local)
	APP_ENV=prod php bin/console cache:warmup

##
## Développement local
##---------------------------------------------------------------------------

.PHONY: serve
serve: ## Démarrer le serveur de développement Symfony (local)
	symfony server:start -d || php -S 127.0.0.1:8000 -t public

.PHONY: serve-stop
serve-stop: ## Arrêter le serveur de développement Symfony (local)
	symfony server:stop || killall php

.PHONY: test
test: ## Lancer les tests (local)
	php bin/phpunit

.PHONY: test-coverage
test-coverage: ## Lancer les tests avec couverture de code (local)
	XDEBUG_MODE=coverage php bin/phpunit --coverage-html var/coverage

##
## Docker Production
##---------------------------------------------------------------------------

.PHONY: prod-build
prod-build: ## Build les images Docker (production)
	$(DOCKER_COMPOSE_PROD) build

.PHONY: prod-up
prod-up: ## Démarrer les conteneurs Docker (production)
	$(DOCKER_COMPOSE_PROD) up -d

.PHONY: prod-down
prod-down: ## Arrêter les conteneurs Docker (production)
	$(DOCKER_COMPOSE_PROD) down

.PHONY: prod-restart
prod-restart: prod-down prod-up ## Redémarrer les conteneurs Docker (production)

.PHONY: prod-ps
prod-ps: ## Lister les conteneurs Docker (production)
	$(DOCKER_COMPOSE_PROD) ps

.PHONY: prod-logs
prod-logs: ## Voir les logs de tous les conteneurs (production)
	$(DOCKER_COMPOSE_PROD) logs -f

.PHONY: prod-logs-php
prod-logs-php: ## Voir les logs du conteneur PHP (production)
	$(DOCKER_COMPOSE_PROD) logs -f $(PHP_SERVICE)

.PHONY: prod-logs-nginx
prod-logs-nginx: ## Voir les logs du conteneur Nginx (production)
	$(DOCKER_COMPOSE_PROD) logs -f $(NGINX_SERVICE)

.PHONY: prod-logs-db
prod-logs-db: ## Voir les logs du conteneur DB (production)
	$(DOCKER_COMPOSE_PROD) logs -f $(DB_SERVICE)

.PHONY: prod-bash
prod-bash: ## Accéder au shell du conteneur PHP (production)
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) bash

.PHONY: prod-bash-nginx
prod-bash-nginx: ## Accéder au shell du conteneur Nginx (production)
	$(DOCKER_COMPOSE_PROD) exec $(NGINX_SERVICE) sh

##
## Cache Docker Production
##---------------------------------------------------------------------------

.PHONY: prod-cache-clear
prod-cache-clear: ## Vider le cache Symfony (production Docker)
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) php bin/console cache:clear --env=prod --no-warmup

.PHONY: prod-cache-warmup
prod-cache-warmup: ## Préchauffer le cache Symfony (production Docker)
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) php bin/console cache:warmup --env=prod

.PHONY: prod-cache-reset
prod-cache-reset: prod-cache-clear prod-cache-warmup ## Réinitialiser le cache Symfony (production Docker)
	@echo "$(COLOR_SUCCESS)✓ Cache réinitialisé en production !$(COLOR_RESET)"

##
## Composer Docker Production
##---------------------------------------------------------------------------

.PHONY: prod-composer-install
prod-composer-install: ## Installer les dépendances Composer (production Docker)
	$(DOCKER_COMPOSE_PROD) exec -u root $(PHP_SERVICE) git config --system --add safe.directory /var/www/symfony || true
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) composer install --no-dev --optimize-autoloader --no-interaction

.PHONY: prod-composer-update
prod-composer-update: ## Mettre à jour les dépendances Composer (production Docker)
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) composer update --no-dev --optimize-autoloader --no-interaction

##
## Base de données Docker Production
##---------------------------------------------------------------------------

.PHONY: prod-db-migrate
prod-db-migrate: ## Exécuter les migrations (production Docker)
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) php bin/console doctrine:migrations:migrate --no-interaction --env=prod

.PHONY: prod-db-status
prod-db-status: ## Voir le statut des migrations (production Docker)
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) php bin/console doctrine:migrations:status --env=prod

##
## Assets Docker Production
##---------------------------------------------------------------------------

.PHONY: prod-assets-build
prod-assets-build: ## Compiler les assets (production Docker)
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) php bin/console asset-map:compile --env=prod

.PHONY: prod-assets-clear
prod-assets-clear: ## Supprimer les assets compilés (production Docker)
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) rm -rf public/assets/*

##
## Configuration Production
##---------------------------------------------------------------------------

.PHONY: prod-setup-env
prod-setup-env: ## Créer les fichiers de config production (première installation)
	@echo "$(COLOR_INFO)Configuration de l'environnement de production...$(COLOR_RESET)"
	@# Créer .env.prod.local (pour Symfony)
	@if [ -f .env.prod.local ]; then \
		echo "$(COLOR_WARNING)⚠️  Le fichier .env.prod.local existe déjà, ignoré.$(COLOR_RESET)"; \
	else \
		echo "$(COLOR_INFO)Création du fichier .env.prod.local (pour Symfony)...$(COLOR_RESET)"; \
		echo "# Configuration Symfony de production - NE PAS COMMITER" > .env.prod.local; \
		echo "" >> .env.prod.local; \
		echo "###> Secrets de production ###" >> .env.prod.local; \
		echo "APP_SECRET=$$(openssl rand -hex 32 2>/dev/null || php -r 'echo bin2hex(random_bytes(32));')" >> .env.prod.local; \
		echo "" >> .env.prod.local; \
		echo "###> Pterodactyl API ###" >> .env.prod.local; \
		echo "PTERODACTYL_ADMIN_API_KEY=" >> .env.prod.local; \
		echo "PTERODACTYL_CLIENT_API_KEY=" >> .env.prod.local; \
		echo "PTERODACTYL_APPLICATION_API_URL=" >> .env.prod.local; \
		echo "PTERODACTYL_CLIENT_API_URL=" >> .env.prod.local; \
		echo "$(COLOR_SUCCESS)✓ Fichier .env.prod.local créé !$(COLOR_RESET)"; \
	fi
	@# Vérifier/créer les variables DB dans .env (pour Docker Compose)
	@echo ""
	@echo "$(COLOR_INFO)Vérification du fichier .env (pour Docker Compose)...$(COLOR_RESET)"
	@if ! grep -q "^DB_NAME=" .env 2>/dev/null; then \
		echo "$(COLOR_WARNING)⚠️  Variables DB manquantes dans .env !$(COLOR_RESET)"; \
		echo "$(COLOR_INFO)Ajout des variables de base de données...$(COLOR_RESET)"; \
		echo "" >> .env; \
		echo "###> Variables Docker Compose Production ###" >> .env; \
		echo "DB_NAME=symfony_prod" >> .env; \
		echo "DB_USER=symfony_prod_user" >> .env; \
		echo "DB_PASSWORD=CHANGEZ_MOI_$$(openssl rand -hex 16 2>/dev/null || php -r 'echo bin2hex(random_bytes(16));')" >> .env; \
		echo "DB_ROOT_PASSWORD=CHANGEZ_MOI_ROOT_$$(openssl rand -hex 16 2>/dev/null || php -r 'echo bin2hex(random_bytes(16));')" >> .env; \
		echo "$(COLOR_SUCCESS)✓ Variables ajoutées dans .env$(COLOR_RESET)"; \
		echo "$(COLOR_WARNING)⚠️  Éditez le fichier .env pour modifier les mots de passe : nano .env$(COLOR_RESET)"; \
	else \
		echo "$(COLOR_SUCCESS)✓ Les variables DB existent déjà dans .env$(COLOR_RESET)"; \
		grep -q "CHANGEZ_MOI" .env && echo "$(COLOR_WARNING)⚠️  Des valeurs 'CHANGEZ_MOI' sont présentes dans .env, pensez à les modifier !$(COLOR_RESET)" || true; \
	fi
	@echo ""
	@echo "$(COLOR_SUCCESS)✓ Configuration terminée !$(COLOR_RESET)"
	@echo "$(COLOR_INFO)Fichiers à vérifier/éditer :$(COLOR_RESET)"
	@echo "  - .env (variables Docker Compose) : nano .env"
	@echo "  - .env.prod.local (secrets Symfony) : nano .env.prod.local"

.PHONY: prod-check-config
prod-check-config: ## Vérifier la configuration de production
	@echo "$(COLOR_INFO)Vérification de la configuration...$(COLOR_RESET)"
	@if [ -f .env.prod.local ]; then \
		echo "$(COLOR_SUCCESS)✓ .env.prod.local existe$(COLOR_RESET)"; \
		grep -q "CHANGEZ_MOI" .env.prod.local && echo "$(COLOR_WARNING)⚠️  Des valeurs par défaut 'CHANGEZ_MOI' sont encore présentes !$(COLOR_RESET)" || echo "$(COLOR_SUCCESS)✓ Pas de valeurs 'CHANGEZ_MOI' détectées$(COLOR_RESET)"; \
	else \
		echo "$(COLOR_WARNING)⚠️  .env.prod.local n'existe pas. Créez-le avec : make prod-setup-env$(COLOR_RESET)"; \
	fi
	@$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) php -m | grep -q pdo_pgsql && echo "$(COLOR_SUCCESS)✓ Extension pdo_pgsql installée$(COLOR_RESET)" || echo "$(COLOR_WARNING)⚠️  Extension pdo_pgsql non trouvée$(COLOR_RESET)"
	@$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) printenv APP_ENV | grep -q prod && echo "$(COLOR_SUCCESS)✓ APP_ENV=prod$(COLOR_RESET)" || echo "$(COLOR_WARNING)⚠️  APP_ENV n'est pas 'prod'$(COLOR_RESET)"

##
## Déploiement Production
##---------------------------------------------------------------------------

.PHONY: deploy
deploy: ## Déploiement complet en production
	@echo "$(COLOR_INFO)Déploiement de $(PROJECT_NAME)...$(COLOR_RESET)"
	git pull --ff-only
	$(DOCKER_COMPOSE_PROD) build
	$(DOCKER_COMPOSE_PROD) up -d
	$(DOCKER_COMPOSE_PROD) exec -u root $(PHP_SERVICE) git config --system --add safe.directory /var/www/symfony || true
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) composer install --no-dev --optimize-autoloader --no-interaction
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) php bin/console doctrine:migrations:migrate --no-interaction --env=prod
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) php bin/console asset-map:compile --env=prod
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) php bin/console cache:clear --env=prod
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) php bin/console cache:warmup --env=prod
	@echo "$(COLOR_SUCCESS)✓ Déploiement terminé pour $(PROJECT_NAME) !$(COLOR_RESET)"

.PHONY: deploy-quick
deploy-quick: ## Déploiement rapide (sans rebuild)
	@echo "$(COLOR_INFO)Déploiement rapide de $(PROJECT_NAME)...$(COLOR_RESET)"
	git pull --ff-only
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) composer install --no-dev --optimize-autoloader --no-interaction
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) php bin/console doctrine:migrations:migrate --no-interaction --env=prod
	$(DOCKER_COMPOSE_PROD) exec $(PHP_SERVICE) php bin/console cache:clear --env=prod
	@echo "$(COLOR_SUCCESS)✓ Déploiement rapide terminé !$(COLOR_RESET)"

##
## Docker Development (optionnel)
##---------------------------------------------------------------------------

.PHONY: dev-up
dev-up: ## Démarrer les conteneurs Docker (développement)
	$(DOCKER_COMPOSE_DEV) up -d

.PHONY: dev-down
dev-down: ## Arrêter les conteneurs Docker (développement)
	$(DOCKER_COMPOSE_DEV) down

.PHONY: dev-bash
dev-bash: ## Accéder au shell du conteneur PHP (développement)
	$(DOCKER_COMPOSE_DEV) exec $(PHP_SERVICE) bash
