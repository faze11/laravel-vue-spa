# laravel-vue-spa
A starter template for a Vue based Laravel SPA application.

### Installation
1. Clone repo
```
git clone https://github.com/faze11/laravel-vue-spa
```

2. Copy .env.example file to .env and fill in URL info
```
APP_URL=http://
MIX_DEV_API_URL=http://
MIX_PROD_API_URL=https://
```

3. Generate keys
```
php artisan key:generate
php artisan jwt:generate
```

4. Run package managers
```
composer install
npm install
```

5. Compile assets
```
npm run hot
```
