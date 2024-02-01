## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)


### Clone the repository

    git clone https://github.com/hayknazaryann/services.git

### Switch to the repo folder

    cd services



### Install all the dependencies using composer

    composer install



### Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

### Generate a new application key

    php artisan key:generate

### Clear caches

    php artisan optimize:clear


### Run the database migrations
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate


### Parse models

    php artisan app:parse-models

### Parse generations

    php artisan app:parse-generations

