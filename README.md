<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Minimal Reproducible Example for Laravel Framework Issue [#54263](https://github.com/laravel/framework/issues/54263)

This repository provides a **minimal reproducible example** of a sorting issue in the Laravel Framework when using the `getRelationExistenceQuery` method. The example revolves around working with `hasOne` relationships and its specific usages like `latestOfMany()` or `one()->ofMany()`.

The issue has been observed while working with Filament tables but is generally applicable to cases involving `hasOne` relationships under similar conditions.

### Prerequisites
- **PHP**: 8.2 or higher (preferably 8.3.15 as tested)
- **MySQL**: Version 8 (mandatory)

### Steps to Set Up

1. Clone the repository:
   ```bash
   git clone https://github.com/BrayanCaro/laravel-get-relation-existence-has-one-issue
   cd laravel-get-relation-existence-has-one-issue
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Configure the `.env` file with your MySQL 8 details:
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. Run migrations and seed the database:
   ```bash
   php artisan migrate --seed
   ```

5. Open the application in your browser and navigate to the `/` GET route:
   ```bash
   php artisan serve
   ```

6. The displayed users are wrong ordered, showing the issue in action.

   Expected order:
   ```json
   [
       {
           "id": 2,
           "name": "Beta"
       },
       {
           "id": 1,
           "name": "Alpha"
       }
   ]
   ```
    
   Actual order:
   ```json
   [
       {
           "id": 1,
           "name": "Alpha"
       },
       {
           "id": 2,
           "name": "Beta"
       }
   ]
   ```

   

### Issue Context

The issue occurs when sorting related models using the `getRelationExistenceQuery` method, sometimes generating conditions such as:
```sql
posts.user_id is null and posts.user_id is not null
```
These conditions logically cannot coexist and lead to unexpected behavior. The issue specifically impacts `hasOne` relationships or its variants like `latestOfMany()` and `one()->ofMany()`.

Here is the problematic part of the generated SQL:
```sql
WHERE `posts`.`user_id` IS NULL
  AND `posts`.`user_id` IS NOT NULL
```

For a full breakdown of the scenario, refer to the associated GitHub issue: [#54263](https://github.com/laravel/framework/issues/54263).
