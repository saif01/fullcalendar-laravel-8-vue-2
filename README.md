# Building a Trello Clone using Laravel and Vue
This is a demo application showing how to fullcalendar npm package use by vue js - v2 with backend laravel- v 8

## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites
What things you need to install the software.

* Git.
* PHP.
* Composer.
* Laravel (optional).
* Laravel Valet (optional).
* A webserver like Apache.
* A Node Package Manager ( npm ).

### Install
Clone the git repository on your computer
```
$ git clone https://github.com/saif01/fullcalendar-laravel-8-vue-2.git
```


After cloning the application, you need to install it's dependencies. 
```
$ cd fullcalendar-laravel-8-vue-2
$ composer install
```

### Setup
- When you are done with installation, copy the `.env.example` file to `.env`
```
$ cp .env.example .env
```

- Generate the application key
```
$ php artisan key:generate
```

- Add your database credentials to the necessary `env` fields

- Migrate the application or import DB QSL file which have in public/db/calendar.sql
```
$ php artisan migrate
```
    

- Install node modules
```
$ npm install
```

### Run the application
```
$ php artisan serve
```

## Built With
* [Laravel](https://laravel.com) - The PHP framework for building the API endpoints needed for the application
* [Vue](https://vuejs.org) - The Progressive JavaScript Framework for building interactive interfaces

## Acknowledgments
* [Laravel](https://laravel.com) - The excellent documentation explaining how to get started with Laravel and Laravel Passport made it easy to provide a step by step guide for beginners to follow the application
* [Vue](https://vuejs.org) - Concise documentation 