# Configuration Production

## Configuration des variables d'environnement

### IMPORTANT : Deux fichiers .env à configurer

Sur le serveur de production, vous devez configurer **2 fichiers distincts** :

#### 1. `.env` - Variables pour Docker Compose
Ce fichier est utilisé par Docker Compose pour créer les conteneurs (notamment la base de données).

**Variables obligatoires** :
- `DB_NAME` : Nom de la base de données PostgreSQL
- `DB_USER` : Utilisateur PostgreSQL
- `DB_PASSWORD` : Mot de passe PostgreSQL
- `DB_ROOT_PASSWORD` : Mot de passe root PostgreSQL

#### 2. `.env.prod.local` - Secrets pour Symfony
Ce fichier est chargé par Symfony **à l'intérieur** du conteneur PHP.

**Variables importantes** :
- `APP_SECRET` : Clé secrète Symfony (générée automatiquement)
- `PTERODACTYL_*` : Clés API si nécessaire

### Ordre de priorité des fichiers .env (Symfony)

Symfony charge les fichiers dans cet ordre (le dernier écrase le précédent) :
1. `.env` - Valeurs par défaut (commitées)
2. `.env.local` - Surcharges locales (non commitées)
3. `.env.prod` - Valeurs spécifiques à prod (commitées)
4. `.env.prod.local` - Secrets de production (non commitées)

### Sur le serveur de production

#### Configuration automatique (recommandé)

```bash
# Se connecter au serveur de production
cd /path/to/your/project

# Créer automatiquement les fichiers de configuration
make prod-setup-env

# Éditer le fichier .env pour les variables Docker Compose
nano .env
# Vérifiez/modifiez les variables DB_NAME, DB_USER, DB_PASSWORD, DB_ROOT_PASSWORD

# Éditer le fichier .env.prod.local pour les secrets Symfony (optionnel, APP_SECRET déjà généré)
nano .env.prod.local
```

#### Configuration manuelle

**1. Fichier `.env` (pour Docker Compose)**

```bash
# Éditer le fichier .env
nano .env
```

Ajoutez/modifiez ces lignes à la fin du fichier :

```bash
###> Variables Docker Compose Production ###
DB_NAME=symfony_prod
DB_USER=symfony_prod_user
DB_PASSWORD=VotreMotDePasseSecurise123!
DB_ROOT_PASSWORD=VotreMotDePasseRootSecurise456!
```

**2. Fichier `.env.prod.local` (pour Symfony)**

```bash
# Créer le fichier
nano .env.prod.local
```

Contenu :

```bash
###> Secrets de production ###
APP_SECRET=VotreCléSecrèteAléatoire_CHANGEZ_MOI

###> Pterodactyl API (si nécessaire) ###
PTERODACTYL_ADMIN_API_KEY=votre_cle_admin
PTERODACTYL_CLIENT_API_KEY=votre_cle_client
PTERODACTYL_APPLICATION_API_URL=https://panel.example.com
PTERODACTYL_CLIENT_API_URL=https://panel.example.com

###> Mailer (si nécessaire) ###
MAILER_DSN=smtp://user:password@smtp.example.com:587
```

#### Méthode 2 : Variables d'environnement Docker

Si vous utilisez Docker Compose en production, le fichier `.env` à la racine du projet sera utilisé automatiquement par Docker Compose.

Sur votre serveur :

```bash
# Copier l'exemple
cp .env.docker.prod.example .env

# Éditer avec vos vraies valeurs
nano .env
```

### Génération d'un APP_SECRET sécurisé

```bash
# Générer une clé secrète aléatoire
php -r "echo bin2hex(random_bytes(32)) . PHP_EOL;"

# Ou
openssl rand -hex 32
```

## Déploiement initial

```bash
# 1. Cloner le projet
git clone <votre-repo> /path/to/project
cd /path/to/project

# 2. Configurer les variables (voir ci-dessus)
nano .env.prod.local  # ou .env pour Docker

# 3. Déployer
make deploy
```

## Déploiements suivants

```bash
# Déploiement complet (avec rebuild)
make deploy

# Déploiement rapide (sans rebuild Docker)
make deploy-quick

# Juste mettre à jour le cache
make prod-cache-reset
```

## Vérifications

### Vérifier les variables dans le conteneur

```bash
# Vérifier APP_ENV
make prod-bash
echo $APP_ENV  # Doit afficher "prod"

# Vérifier la connexion DB
php bin/console dbal:run-sql "SELECT 1"
```

### Vérifier les logs

```bash
# Logs PHP
make prod-logs-php

# Logs Nginx
make prod-logs-nginx

# Logs PostgreSQL
make prod-logs-db
```

## Sécurité

**IMPORTANT** :
- Ne JAMAIS commiter les fichiers `.env.prod.local` ou `.env` avec les vraies valeurs
- Utilisez des mots de passe forts et uniques
- Changez `APP_SECRET` pour chaque environnement
- Limitez les accès SSH au serveur de production
- Utilisez HTTPS (géré par Traefik dans votre config)

## Troubleshooting

### Erreur "could not find driver"
- Vérifier que `pdo_pgsql` est installé : `make prod-bash` puis `php -m | grep pdo_pgsql`
- Rebuild les images : `make prod-build`

### Erreur DebugBundle not found
- Vérifier que `APP_ENV=prod` : `make prod-bash` puis `echo $APP_ENV`
- Vérifier dans docker-compose.prod.yml que la variable est bien définie

### Base de données non accessible
- Vérifier que le conteneur DB tourne : `make prod-ps`
- Vérifier les logs : `make prod-logs-db`
- Vérifier les variables DB dans le fichier `.env` ou `.env.prod.local`
