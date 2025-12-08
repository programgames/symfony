#!/bin/bash

# Script de génération de secrets pour la production
# Usage: ./scripts/generate-secrets.sh

set -e

COLOR_INFO='\033[36m'
COLOR_SUCCESS='\033[32m'
COLOR_WARNING='\033[33m'
COLOR_RESET='\033[0m'

echo -e "${COLOR_INFO}Génération des secrets de production...${COLOR_RESET}"

# Générer APP_SECRET
APP_SECRET=$(openssl rand -hex 32)

# Générer des mots de passe sécurisés pour la base de données
DB_PASSWORD=$(openssl rand -base64 32 | tr -d "=+/" | cut -c1-25)
DB_ROOT_PASSWORD=$(openssl rand -base64 32 | tr -d "=+/" | cut -c1-25)

# Encoder le mot de passe pour l'URL
DB_PASSWORD_ENCODED=$(echo -n "$DB_PASSWORD" | jq -sRr @uri)

echo -e "${COLOR_SUCCESS}Secrets générés !${COLOR_RESET}"
echo ""
echo -e "${COLOR_INFO}=== Fichier .env (pour Docker Compose) ===${COLOR_RESET}"
echo "DB_PASSWORD=\"$DB_PASSWORD\""
echo "DB_PASSWORD_ENCODED=\"$DB_PASSWORD_ENCODED\""
echo "DB_ROOT_PASSWORD=\"$DB_ROOT_PASSWORD\""
echo ""
echo -e "${COLOR_INFO}=== Fichier .env.prod.local (secrets Symfony) ===${COLOR_RESET}"
echo "APP_SECRET=$APP_SECRET"
echo ""
echo -e "${COLOR_WARNING}⚠️  Copiez ces valeurs dans vos fichiers de configuration !${COLOR_RESET}"
echo ""
echo -e "${COLOR_INFO}Pour mettre à jour automatiquement (ATTENTION: écrase les valeurs existantes):${COLOR_RESET}"
echo "  # Mettre à jour .env"
echo "  sed -i \"s|DB_PASSWORD=.*|DB_PASSWORD=\\\"$DB_PASSWORD\\\"|\" .env"
echo "  sed -i \"s|DB_PASSWORD_ENCODED=.*|DB_PASSWORD_ENCODED=\\\"$DB_PASSWORD_ENCODED\\\"|\" .env"
echo "  sed -i \"s|DB_ROOT_PASSWORD=.*|DB_ROOT_PASSWORD=\\\"$DB_ROOT_PASSWORD\\\"|\" .env"
echo ""
echo "  # Mettre à jour .env.prod.local"
echo "  echo \"APP_SECRET=$APP_SECRET\" >> .env.prod.local"