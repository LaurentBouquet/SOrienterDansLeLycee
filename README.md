# S'Orienter Dans Le Lycee

Application web Symfony pour guider les utilisateurs dans un lycee via un calcul d'itineraire interne (algorithme de Dijkstra), avec gestion des droits par roles et administration des lieux/connexions.

## Fonctionnalites

- Calcul d'itineraire entre deux points du lycee.
- Filtrage PMR pour exclure les passages non accessibles.
- Affichage des etapes avec instructions et images associees.
- Espace authentification (connexion, inscription, deconnexion).
- Gestion des lieux (`Location`) reservee aux profils enseignant (`ROLE_PROF`).
- Gestion des connexions (`Connection`) reservee aux profils enseignant (`ROLE_PROF`).
- Gestion des utilisateurs reservee aux administrateurs (`ROLE_ADMIN`), creation/modification limitees a `ROLE_SUPER_ADMIN`.
- Vue boussole accessible aux utilisateurs connectes (`ROLE_USER`).

## Stack Technique

- PHP 8.2+
- Symfony 7.4
- Doctrine ORM + Migrations
- Twig + Asset Mapper
- PHPUnit 12
- Base de donnees: MySQL/MariaDB (configuration actuelle)
- Docker Compose disponible pour services de dev (PostgreSQL, Mailpit)

## Prerequis

- PHP >= 8.2
- Composer
- Une base de donnees MySQL/MariaDB (ou PostgreSQL si vous adaptez `DATABASE_URL`)
- (Optionnel) Docker + Docker Compose

## Installation Rapide

1. Installer les dependances:

```bash
composer install
```

2. Configurer la base de donnees dans `.env.local`:

```dotenv
DATABASE_URL="mysql://<A_COMPLETER>"
APP_ENV=dev
```

3. Creer le schema:

```bash
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate -n
```

4. Charger les donnees de demonstration (uniquement pour le dev):

```bash
php bin/console doctrine:fixtures:load -n
```

5. Lancer l'application:

```bash
symfony serve
```

Alternative sans Symfony CLI:

```bash
php -S 127.0.0.1:8000 -t public
```

## Option Docker (Services)

Le projet contient `compose.yaml` + `compose.override.yaml` pour lancer des services de support:

- `database`: PostgreSQL (port expose dynamiquement par Docker)
- `mailer`: Mailpit (SMTP et UI web)

Demarrage:

```bash
docker compose up -d
```

Si vous utilisez PostgreSQL via Docker, adaptez `DATABASE_URL` en consequence (exemple):

```dotenv
DATABASE_URL="postgresql://<A_COMPLETER>"
```

## Mise En Production

Checklist recommandee:

1. Definir des variables d'environnement de production (secrets hors Git):

```dotenv
APP_ENV=prod
APP_DEBUG=0
APP_SECRET=<A_COMPLETER>
DATABASE_URL=<A_COMPLETER>
MAILER_DSN=<A_COMPLETER>
```

2. Installer les dependances et les assets sans outils de dev:

```bash
composer install --no-dev --optimize-autoloader
php bin/console asset-map:compile --env=prod
```

3. Mettre la base a jour:

```bash
php bin/console doctrine:migrations:migrate -n --env=prod
```

4. Preparer le cache:

```bash
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod
```

5. Configurer le serveur web pour pointer vers `public/`.

6. Ne pas charger les fixtures en production.

7. Verifier les logs apres demarrage:

```bash
tail -f var/log/prod.log
```

## Routes Principales

- `/` : page d'accueil
- `/algo/new` : formulaire de calcul d'itineraire
- `/algo/path` : resultat de l'itineraire
- `/compass` : vue boussole (connecte)
- `/login`, `/register`, `/logout` : securite
- `/location/*` : CRUD lieux (`ROLE_PROF`)
- `/connection/*` : CRUD connexions (`ROLE_PROF`)
- `/user/*` : gestion utilisateurs (`ROLE_ADMIN` / `ROLE_SUPER_ADMIN`)

## Commandes Utiles

```bash
# Cache
php bin/console cache:clear

# Voir les routes
php bin/console debug:router --raw

# Lancer les tests
php bin/phpunit

# Compiler les assets
php bin/console asset-map:compile
```

## Structure Du Projet

- `src/Controller` : controleurs HTTP
- `src/Entity` : modeles Doctrine (`User`, `Location`, `Connection`)
- `src/Form` : formulaires Symfony
- `src/DataFixtures` : donnees de demonstration
- `src/Service` : services metier (upload fichiers, etc.)
- `templates/` : vues Twig
- `config/` : configuration Symfony/Doctrine/Security
- `tests/` : tests fonctionnels

## Qualite Et Evolution

Pistes d'amelioration recommandees:

- Ajouter davantage de tests fonctionnels autour du parcours PMR.
- Renforcer la validation metier sur les connexions (coherence bidirectionnelle, poids, images).
- Uniformiser la config base de donnees entre `.env`, `.env.local` et Docker pour simplifier l'onboarding.

## Licence

Projet academique/proprietaire (voir `composer.json`: `license: proprietary`).
