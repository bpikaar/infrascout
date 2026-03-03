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

## Use ImageMagick

Daarvoor gebruik ik een package imagick. Echter ImageMagick moet zélf gecompileerd zijn met ondersteuning voor het HEIF/HEIC-formaat, en daarvoor moet de systeembibliotheek libheif geïnstalleerd zijn.
Daarvoor zou echter het volgende uitgevoerd moeten worden:
```bash
sudo apt-get install libheif-dev
sudo apt-get install --reinstall imagemagick
# Eventueel ook de PHP imagick extensie opnieuw compileren:
sudo pecl install imagick
```
en de server zou moeten restarten.

### Check input
```php
<?php
if (!extension_loaded('imagick')) {
    echo "~]~L Imagick extensie is NIET geladen.<br>";
    exit;
}
echo "~\~E Imagick extensie is geladen.<br><br>";

// 2. Toon ImageMagick versie
$imagick = new Imagick();
$version = $imagick->getVersion();
echo "<strong>ImageMagick versie:</strong><br>";
echo $version['versionString'] . "<br><br>";

// 3. Controleer of HEIC ondersteund wordt
$formats = Imagick::queryFormats();

if (in_array('HEIC', $formats)) {
    echo "~\~E HEIC wordt ondersteund door ImageMagick.<br>";
} else {
    echo "~]~L HEIC wordt NIET ondersteund door ImageMagick.<br>";
}

// 4. Toon expliciet of HEIF bestaat (soms aparte vermelding)
if (in_array('HEIF', $formats)) {
    echo "~\~E HEIF wordt ondersteund.<br>";
}

echo "<br><strong>Beschikbare HEI-gerelateerde formats:</strong><br>";
foreach ($formats as $format) {
    if (stripos($format, 'hei') !== false) {
        echo $format . "<br>";
    }
}

?>
```
### output
HEIC Support Check
- ✅ Imagick extensie is geladen.

ImageMagick versie:
`ImageMagick 7.1.1-47 Q16-HDRI x86_64 22763` https://imagemagick.org

- ✅ HEIC wordt ondersteund door ImageMagick.
- ✅ HEIF wordt ondersteund.


Beschikbare HEI-gerelateerde formats:
HEIC, HEIF
