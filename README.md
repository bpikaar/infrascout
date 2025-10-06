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
$imgPath = public_path('images/reports/'.$report->id.'/'.$image->path);
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
