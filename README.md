PART 1

Overview

This project allows users to register and manage a fleet of vehicles, keeping track of each vehicle's registration within a fleet.

Stack :
PHP 8.1
Composer
Behat

Architecture

This project uses a Domain-Driven Design (DDD).

Installation

1- Clone the project repository.

2- Navigate to the project directory.

3- Run `composer install` to install dependencies.

4- Run behat test with `php vendor/bin/behat`.

PART 2

Stack :
PHP 8.1
Symfony 5.4
XAMPP / MYSQL

Project Setup and Usage Guide

Installation

1- Clone the project repository.

2- Navigate to the project directory.

3- Run `composer install` to install dependencies.

Database Setup

1- Ensure XAMPP/MAMP/LAMP or WAMPP is running MySQL.

2- Create a database named hiring in your MySQL instance.

3- Configure the .env file with your database connection details.

4- Run `php bin/console doctrine:migrations:migrate` to set up the database schema.

Using Commands

This is the different command :

Create Fleet: php bin/console fleet:create < userId >
Register Vehicle: php bin/console fleet:register-vehicle < fleetId > < vehiclePlateNumber >
Localize Vehicle: php bin/console fleet:localize-vehicle < fleetId > < vehiclePlateNumber > < lat > < lng > [< alt >]
 
Ensure to replace placeholders <...> with actual values.

