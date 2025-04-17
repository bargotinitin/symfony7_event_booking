# Introduction

  Event booking API demonstration using Symfony 7.0.10.

  ## Tech Stack Used
    Programming language - PHP 8.2
    Dependency management - composer 2
    Web Server - Apache 2
    Database - MySQL 8

# Checkout or clone the code from repo
  1. git init
  2. git remote add origin https://github.com/bargotinitin/symfony7_event_booking.git
  3. git checkout -b master
  4. git pull origin master

# Dependency installation
    composer install

# Configure database
Make sure from .env file database is mapped.

# Database creation
    php bin/console doctrine:database:create

# SQL file import
  1. Empty migrations folder, now fire further commands.
  2. php bin/console make:migration
  3. php bin/console doctrine:migrations:migrate

If above steps do not work, import db.sql into database which is provided in root folder.

# Running the application - fire below command.
    php -S 127.0.0.1:8000 -t public

# APIs

  1. For getting events: http://127.0.0.1:8000/api/event - GET

  2. For Creating an event: http://127.0.0.1:8000/api/event - POST
    -- Please refer post.txt for json which has to be passed in body.

  3. View event - http://127.0.0.1:8000/api/event/1 - GET

  4. Update event - http://127.0.0.1:8000/api/event/1 - PUT, PATCH
    -- Please refer post.txt for json which has to be passed in body.

  5. Delete event - http://127.0.0.1:8000/api/event/1 - DELETE

  6. For getting all users - http://127.0.0.1:8000/api/users - GET

  7. For adding an user - http://127.0.0.1:8000/api/user - POST
    -- Please refer post.txt for json which has to be passed in body.

  8. Add an attendee - http://127.0.0.1:8000/api/add/attendee - POST
    -- Please refer post.txt for json which has to be passed in body.

  9. Create a booking - http://127.0.0.1:8000/api/add/booking - POST
    -- Please refer post.txt for json which has to be passed in body.


# Postman collection

  ## For using the APIs in postman, please import this collection.
    File name: Event Booking Collection.postman_collection.json

# Test

  ## Fire this command for creating separate database for testing.
    php bin/console doctrine:database:create --env=test

  ## The below command will copy tables from the existing database.
    php bin/console doctrine:migrations:migrate --env=test

  If things do not work, manually create database and import db.sql again in test database.

  Note: if database name is demo, then for running tests keep database name demo_test.

# Run individual tests
    php bin/phpunit tests/UserControllerTest.php
    php bin/phpunit tests/EventControllerTest.php
    php bin/phpunit tests/AttendeeControllerTest.php
    php bin/phpunit tests/BookingControllerTest.php

# Run all tests in one go
    php bin/phpunit tests
