
# Air Fresh Shop

Voici le guide d'installation.

## Équipement sur lequel le projet a été développé

**Symfony:** V. 6.0.8

**PHP:** V. 8.1.0


## Déploiement du projet

Pour déployer ce projet, veuillez suivre les instructions :

```bash
1- Télécharger le fichier zip
2- Déziper le fichier
3- Faites un composer install pour installer toutes les dépendances composer du projet
4- Modifier la ligne DATABASE_URL à votre convenance sur le fichier .env
5- Faites un symfony console doctrine:database:create pour créer la base de données
6- Faites un php bin/console make:migration pour préparer la migration
7- Faites un php bin/console doctrine:migrations:migrate pour effectuer la migration
8- Exécuter les dataFixtures avec la commande : php bin/console doctrine:fixtures:load
9- Faites un symfony serve
```


## FAQ

#### Comment s'enregistrer en tant qu'utilisateur ?

Sur localhost, cliquez sur le bouton Inscription, et remplissez le formulaire. La route est /register.

#### Comment se connecter ?

Une fois le compte créé, vous $etes redirigé sur la page du login. La route est /login.

#### Comment consulter les produits du site ?

En étant connecté ou non, on peut visiter les produits par catégories via le dropdown Catégories.

#### Comment mettre des produits dans son panier ?

Vous pouvez mettre des produits dans le panier en n'étant pas connecté et le panier, une fois connecté ou une fois enregistré, le panier est conservé lors d'une même session. La route du panier est /cart. 

#### Comment passer commande ?

Une fois sur le panier, il faut remplir le formulaire pour passer la commande. Et une fois cela effectué, on est redirigé sur la page de l'historique de nos commandes. On peut accéder à cette page directement sur /purchases, ou en cliquant sur le bouton Mes Commandes de la navbar.

#### Quelles sont les droits de l'admin ? (admin)

Une fois connecté en tant qu'admin, on a un dropdown Admin. Seulement les liens vers les fonctionnalités d'ajout fonctionnent. Les routes : 
- pour créer une catégorie : /admin/category/create
- ajouter un produit : /admin/product/create
- éditer une catégorie : admin/category/*id de la category dans la bdd*/edit
- éditer un produit : admin/product/*id du produit dans la bdd*/edit
- la fonctionnalité pour consulter la liste des utilisateurs n'est pas encore implémentée, même si elle figure dans le dropdown
