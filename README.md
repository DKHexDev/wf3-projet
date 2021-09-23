# WF3 Projet

Pour récupèrer le projet :

```bash
git clone https://github.com/DKHexDev/wf3-projet.git
cd wf3-projet
composer install
```

S'il y a un blocage au niveau du `composer install` à cause de la version de PHP :

```bash
composer update
```

Pour configurer la base de données, on n'oublie pas de créer un fichier `.env.local` avec les lignes suivantes (La ligne suivante est configurer pour Xampp) :

```bash
DATABASE_URL="mysql://root:@127.0.0.1:3306/wf3-projet?serverVersion=5.7"
```

Attention de bien créer la BDD :

```bash
php bin/console doctrine:database:create
```

Et aussi, il faut synchroniser la BDD :

```bash
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```


