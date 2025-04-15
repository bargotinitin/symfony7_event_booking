# Introduction

Event booking API demonstration using Symfony 7.0.10.
PHP 8.2 is used.

# Checkout or clone the code from repo
  git init
  git remote add origin https://github.com/bargotinitin/symfony7_event_booking.git
  git checkout -b master
  git pull origin master

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




