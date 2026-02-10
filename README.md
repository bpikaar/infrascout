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

#### known issue
The problem: The Blade compiler can have issues with multi-line `@php` blocks, especially when nested inside loops like `@foreach`. When Blade compiles `@php...@endphp` to raw PHP, it can sometimes create parsing conflicts with the surrounding Blade directives, leading to "unexpected token" errors.

domPdf recently shows issues with `@php` directives

```php
<?php ?>
// instead of 
@php
    somehing
@endphp
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

```
nohup php artisan queue:work --daemon &
```

First I needed: stackoverflow.com/a/29292637/470749 

Then nohup php artisan queue:work --daemon > storage/logs/laravel.log & worked for me. Note: if you want to kill the nohup daemon, you need to first discover its PID by running something like 
```
ps -ef |grep artisan
```
. Then you can run kill [pid]

https://laracasts.com/discuss/channels/laravel/queuework-no-way-to-keep-it-running
