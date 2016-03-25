## Alternativet Services API

Services back-end for Alternativet, based on the Laravel framework, Dingo, and the  [vue-starter Frontend App](https://github.com/layer7be/vue-starter)

## Installation

### Step 1: Clone the repo
```
git clone https://github.com/partialternativet/api
```

### Step 2: Prerequisites
```
composer install
touch database/database.sqlite
php artisan migrate
php artisan db:seed
php artisan key:generate
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
```

### Step 3: Serve
```
php artisan serve
```

### Note about Apache
If you use Apache to serve this, you will need to add the following 2 lines to your .htaccess (or your virtualhost configuration):
```
RewriteCond %{HTTP:Authorization} ^(.)
RewriteRule . - [e=HTTP_AUTHORIZATION:%1]
```
