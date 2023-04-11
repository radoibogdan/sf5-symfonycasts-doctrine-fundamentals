# Création Api

## Démarrer serveur en local
```bash
$ symfony serve -d
```
Lien pour accéder à l'interface: https://127.0.0.1:8000

### Database docker
Crée fichier `docker-composer.yaml` pour la config
Changer le port en '3308:3306' et bdd 'mysql:8.0'
LE port 3308 de notre pc est partagé avec le port 3306 du conteneur
Modifie server_version: '8.0' dans doctrine.yaml
```bash
$ php bin/console make:docker:database
```

### Run/Stop database container
Docker desktop doit être ouvert à ce point pour que la commande docker-compose fonctionne
```bash
$ docker-compose up -d (-d=deamon mode in background)
$ docker-compose stop
```
### Voir tous les conteneurs 
```bash
$ docker-compose ps
```
### Se connecter à mysql du conteneur
Port de notre pc et mdp de la bdd du conteneur depuis `docker-composer.yaml`
```bash
$ mysql -u root --password=password --host=127.0.0.1 --port=3308
$ docker-compose exec database mysql -u root --password=password
```

### Installer une extension pour twig pour rendre des dates relatives ("2 dqys ago")
```bash
$ composer req knplabs/knp-time-bundle
```

### Créer une entité
```bash
$ symfony console make:entity Question
$ symfony console make:migration
$ symfony console d:m:m
```

composer req knplabs/knp-snappy-bundle:^1.6

## Fixtures Zenstruck Foundry
[Zenstruck Documentation][1]
```bash
$ composer req orm-fixtures --dev
$ symfony console doctrine:fixtures:load
$ composer req zenstruck/foundry --dev
  + Add to bundles.php
  Zenstruck\Foundry\ZenstruckFoundryBundle::class => ['dev' => true, 'test' => true]
$ symfony console make:factory 
```

### Faker
[Faker Documentation][2]

## Stof Bundle
[Documentation Stof][3]
[Stof Symfony][4]

### Installation + config `stof_doctrine_extensions.yaml`
```bash
$ composer require stof/doctrine-extensions-bundle
```


# Tests (pas sur ce projet)
Jouer les tests (srs/tests):

```bash
$ php bin/phpunit
```

[1]: https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#reusable-model-factory-states
[2]: https://github.com/FakerPHP/Faker
[3]: https://github.com/stof/StofDoctrineExtensionsBundle
[4]: https://symfony.com/bundles/StofDoctrineExtensionsBundle/current/index.html