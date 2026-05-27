# ОчУмелые ручки

Платформа для записи на мастер-классы по творчеству.

## Быстрый запуск

### Требования
- PHP 8.3+
- Composer
- MySQL

### Установка

```bash
git clone https://github.com/sakovaalina130-rgb/ouchumelye-laravel.git
cd ouchumelye-laravel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
