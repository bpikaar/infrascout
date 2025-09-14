# Infrascout rapporten

## installation

- clone
- `composer run dev`

### images

- create a symlink
  ```bash
  php artisan storage:link
  ```

## plugins

- Breeze
- DomPdf

  https://github.com/barryvdh/laravel-dompdf

## publish vendor

```
php artisan vendor:publish
```

Choose `Barryvdh\DomPDF\ServiceProvider`
