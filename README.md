# Infrascout rapporten

## installation

- clone
- `composer run dev`

### images

- create a symlink
  ```bash
  php artisan storage:link
  ```
- start queue worker
  ```bash
  php artisan queue:work -v
  ```
### ENV

```bash
APP_LOCALE=nl
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
```

## plugins

- Breeze 

### DomPdf

https://github.com/barryvdh/laravel-dompdf

Dompdf need public links to images with `public_path`
```
$imgPath = public_path('/storage/images/reports/'.$report->id.'/'.$image->path);
```

[IMPORTANT!!]
if the generation of a pdf changes in `GenerateReportPdf` restart queue worker
```bash
php artisan queue:work
```

#### known issues
The problem: The Blade compiler can have issues with multi-line `@php` blocks, especially when nested inside loops like `@foreach`. When Blade compiles `@php...@endphp` to raw PHP, it can sometimes create parsing conflicts with the surrounding Blade directives, leading to "unexpected token" errors.

domPdf recently shows issues with `@php` directives

```php
<?php ?>
// instead of 
@php
    somehing
@endphp
```

pre-wrap in classes can mess up with the spacing. 
```html
<div class="panel" style="white-space: normal;">
```

## publish vendor

```
php artisan vendor:publish
```

Choose `Barryvdh\DomPDF\ServiceProvider`

### localization 

language folder has been published through
```bash
php artisan lang:publish
```

## live server

On the server the queue is running under `screen`

type to enter screen (attach)
```bash
screen -r
```

here runs 
```bash
php artisan queue:work
```

Het standaard php artisan queue:work commando draait tegenwoordig altijd als daemon. Het laadt het framework één keer en blijft draaien tot je het handmatig stopt.

## Navigate to window
`CTRL + A + "`

`CTRL + A + d` (detach)


**REMEMBER TO RESTART queue:work after code update**

