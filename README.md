# REST API Movie
REST API sederhana untuk film

## Install
    composer install
    composer dump-autoload

## Run Migration
	php artisan migrate

## Run the app
    php -S localhost:8080 -t public

## Run unit tests
    vendor/bin/phpunit

# REST API

REST API untuk movie
> Note: setiap endpoint REST API Movie membutuhkan header token
[Endpoint Get Token](#endpoint-get-token "Endpoint Get Token")

> Note: Setiap response berupa JSON

<br />

|  REST API    | Method | Endpoint | Header |  Parameter  |
| ------------- | ------------ | ------------ | ------------ | ------------ |
|  Get Lists Movie  |  GET  | api/movies |  token : eyJ0eXAiOiJKV&hellip; |    |
|  Get Movie  | GET |  api/movies/:ID  |  token : eyJ0eXAiOiJKV&hellip;  |    |
|  Add New Movie | POST |  api/movies  |   token : eyJ0eXAiOiJKV&hellip;, Content-Type : multipart/form-data  |  [title, rating, description, image (file)]  |
|  Update Movie  |  POST  |  api/movies/:ID  |  token : eyJ0eXAiOiJKV&hellip;, Content-Type : multipart/form-data  | [title, rating, description, image (file)] |
|  Delete Movie  |  DELETE  |  api/movies/:ID |  token : eyJ0eXAiOiJKV&hellip;  |  |
<br />

##### Endpoint Get Token
	curl --request GET \ --url http://localhost:81/api/get-token
