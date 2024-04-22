# imaginacms-ifeed

## Install
```bash
composer require imagina/ifeed-module=v8.x-dev
```

## Enable the module
```bash
php artisan module:enable Ifeed
```

## Migrate

```bash
php artisan module:migrate Ifeed
```

## Seeder

```bash
php artisan module:seed Ifeed
```

## Publish Config Feed

```bash
php artisan vendor:publish --provider="Spatie\Feed\FeedServiceProvider" --tag="feed-views"
```

## Update View to Products
In /config/asgard/feed.php
```bash
 'view' => 'ifeed::frontend.product.feed',
```

## URL

### Base
    mywebsiteurl/feed/products

### With params

    /feed/products?filter={"category":x}&take=x

    /feed/products?filter[category]=x&take=x 
