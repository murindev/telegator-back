## Telegram MVP backend

### soft

- `TDlib`
    - `gperf`
    - `zlib1g-dev`
    - `php-all-dev`

- `redis`
- `MySQL 8.0+ | MariaDB 10.5+`
- `composer` [link](https://getcomposer.org/)
- `php 7.4+`
    - `BCMath PHP Extension`
    - `Ctype PHP Extension`
    - `Fileinfo PHP Extension`
    - `JSON PHP Extension`
    - `Mbstring PHP Extension`
    - `OpenSSL PHP Extension`
    - `PDO PHP Extension`
    - `Tokenizer PHP Extension`
    - `XML PHP Extension`
    - `PHP LDlib extension` [install](https://yaroslavche.github.io/phptdlib/installation.html)

### first start

```bash
cd /path/to/project
composer install
#php composer.phar install
php artisan migrate
##Install passport for Auth
php artisan passport:install
```

