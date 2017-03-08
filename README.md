ekyna-learn/sf-blog
=======

Développer un blog avec Symfony _(Routing, Twig et Formulaire)_.

### Installation

1. Cloner ce dépôt

        git clone https://github.com/ekyna-learn/sf-blog
    
2. Installer les dépendances

        cd sf-blog
        composer install
    
3. Créer la base de données et le schéma

        php app/console doctrine:database:create
        php app/console doctrine:schema:create

4. Charger le jeu de test

        php app/console doctrine:fixtures:load
        

### Développer le blog

Créer les routes, contrôleurs, formulaires et templates pour les urls suivantes :

| Url | Action |
|-----|--------|
| GET __/category-slug__ | Détail de la catégorie et liste des articles associés. |
| GET/POST __/category-slug/post-slug__ | Détail de l'article, liste des commentaires et formulaire pour ajouter un commentaire. |
    
    