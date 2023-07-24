# Laravel Webshop Filament Support</span>

---
## The goal of the project:
To provide a set of easily customizable [Filament](https://filamentphp.com/) admin resources for the [Laravel Webshop package](https://github.com/dv5150/shop).

---

## Requirements
- Laravel 8+
- PHP >=8.1

---

## Setup
`$ composer require "dv5150/shop-filament"`


## User model setup
This package does not include a User Filament resource. However, if you would like to, you can display a user's previous orders on their admin page,
just update your own `User Filament resource` with the following:
```php
use DV5150\Shop\Filament\Resources\UserResource\RelationManagers;

public static function getRelations(): array
{
    return [
        OrdersRelationManager::class,
    ];
}
```