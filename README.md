# RoboDance application

## About App

"RoboDance" is a simple web application made as a coding challenge.
Imagine a world where all robots have only one goal - to win the Robo-Dance competition!

## Task

Backend: Create a simple REST API to provide the robots with the stage they were always dreaming about.  
Frontend: Create a simple frontend web application to provide the robots with the stage they were always dreaming about.

## Installation

### Requirements

- php 7.4 +
- mysql/maria or sqlite database
- composer
- nodejs and npm (for development only)

### Steps

- pull code from GitHub
- composer install
- npm install (for development only)
- make a schema in database
- create ENV file with database setup (mysql or sqlite)
- artisan:
    - generate key
    - migrate and seed data (not necessary if using existing sqlite db file)
- make a local domain on web server or use Laravel serve

## Description

Migrations and seeds generate a DB tables and fill tables with some (fake) robots and dance offs.    
User can show robots, details about every robot, previous competitions and leaderboard. Also, user can organize new dance off. Winner and loser are defined on random principle.  
App is optimized for desktop and mobile devices.

### API routes

GET
```
- /api/robots (get all robots)
- /api/robots/{id} (get a specific robot)
- /api/danceoffs (get the 100 latest danceoffs)
- /api/danceoffs/populated (get the 100 latest danceoffs with populated robot models)
```
POST
```
- /api/danceoffs (create danceoffs between robots)
```
POST request example
```
{
  "danceoffs": [    
    {
      "winner": 10,
      "opponents": [
        7,
        10
      ]
    },
    {
      "winner": 4,
      "opponents": [
        11,
        4
      ]
    }
  ]
}
```

## Used technologies

- [Laravel framework](https://laravel.com/)
- [VueJS](https://vuejs.org/)
- [Tailwind CSS](https://tailwindcss.com/)


## Contributors

- [Darko Dujin](https://github.com/daxter75)

## License

Copyright © 2021.
