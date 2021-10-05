# WF3 Projet

Pour récupèrer le projet :

```bash
git clone https://github.com/DKHexDev/wf3-projet.git
cd wf3-projet
composer install
npm install
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

# Tailwind CSS

Pour ajouter/customiser des class Tailwind CSS :
    
Direction dans le fichier :

```  
./assets/styles/app.css
```

Vous pourrez alors ajouter les classes que vous voulez ajouter a Tailwind dans :

```
@layer components {
    // Votre classe ici
}
```

Il faudra ensuite compiler le CSS de app.css, c'est à dire transformer les @... en code CSS
Pour cela exécuter la commande : 

```
npm run dev
```

Et bien jouer, votre CSS est maintenant compiler et disponible dans

```
./public/build/
```

Mais ne toucher pas au dossier build, il faudra toujours compilé si vous voulez modifier ce dossier grace au app.css

Quelques commandes supplémentaires :

Pour évitez d'être obligé de toujours compiler quand vous ajouté des class, il faudra au prèalable éxecuter la commande : 

```
npm run dev-server
```

Et après avoir éxecuter cette commande, lorsque que vous allez enregistrer des modifications dans app.css
ils seront automatiquement compiler, sympa pour le dev :)

Et une dernière commande que vous n'allez surement pas éxecuter car cette commande s'utilise pour la prod, c'est
pour compiler et minifier le code CSS, donc on utilisera cette commande lorsque nous passerons en prod.

```
npm run build
```

Sinon, toutes les classes de Tailwind sont déjà disponible et prêt à l'utilisation dans les fichiers .html.twig si une compilation à été faîtes.

Documentation de Tailwind CSS : https://tailwindcss.com/docs

aline