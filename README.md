<h1 align="center">Reservations</h1> 
<h2 align="center">A Laravel group project</h2>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About

Le projet tourne autour de la gestion des réservations de spectacles d’une société de production.
Celle-ci gère un catalogue reprenant des spectacles, leurs auteurs et leurs metteurs en scènes, les comédiens, ainsi que les lieux et les dates de représentations.

<b>L’internaute </b> peut consulter librement le catalogue des spectacles affichant le lieu et les prochaines dates de représentation. Il pourra effectuer des recherches, des tris et des filtres à travers les pages du catalogue.

<b>Le membre</b> peut réserver des places pour une représentation d’un spectacle (en passant notamment par une plateforme de paiement en ligne comme [Stripe](https://stripe.com/fr-be/)),
consulter la liste de ses réservations (son profil) et modifier ses données de profil.

<b>L’administrateur</b> peut gérer son catalogue à travers un back-office sécurisé. Par exemple, il peut ajouter, modifier et supprimer un spectacle manuellement, importer/exporter des données au format CSV, mais aussi mettre à jour la liste des spectacles grâce aux nouveautés publiées par un Web service tiers.

L’application produit d'autre part son propre Web service (une API authentifiée avec système d’affiliation).

## Additional information

Le projet est réalisé avec le framework back-end (PHP, programmation orientée objet) Laravel 8.x Breeze (starter kit pour l'authentification).</br>
Ainsi, Tailwind est le framework css utilisé.</br>
Quant au front-end, c'est le framework vue.js qui est exploité.

-   **[Tailwind css](https://tailwindcss.com/)**
-   **[Vue js](/https://vuejs.org//)**

## Installation

### Ce projet utilise PHP version 8.0.7

Pour installer les dépendances, lancer successivement :

### `composer install`

### `npm install`

Afin de remplir la base de données :

### `php artisan db:seed`

Afin d'obtenir les images et les BREAD dans le back offices :

### `php artisan cache:clear`

### `php artisan storage:link`

## Contributing

## Authors and acknowledgment

<ul>
    <li>Myriam K</li>
    <li>Nathalie S</li>
    <li>Simon O</li>
    <li>Gregory V.O</li>
</ul>

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Project status

In progress...
