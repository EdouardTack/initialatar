# PHP avatar with initial's name

This create an avatar with the first letters of the names, or with the first letter of one string.

## Requirements

* PHP >= 7
* GD library
* FreeType library

## Load it

Load the library with composer

```sh
php composer.phar require edouardtack/initialatar "dev-master"
```

OR add this lines to your `composer.json`

```sh
"require": {
	"edouardtack/initialatar": "dev-master"
}
```

And run `php composer.phar update`

## Use it

### Instance the Initialatar

```php
use Initialatar\Initialatar;

$oInitialatar = new Initialatar([
    'name'      => "Edouard Tack",
    'width'     => 50,
    'height'    => 50,
    'ellipse'   => true,
    'font'      => true
]);

// Create the image ressource
$oInitialatar->create();

// Save to file
$oInitialatar->save('test.png');
```

### Display in your view

```html
<img src="<?php echo $oInitialatar->display(); ?>">
```

## Documentation

### Parameters

```php
[
    'name'      => "My Name", // the string to initialatar
    'width'     => 50, // Width of the return image
    'height'    => 50, // Height of the return image
    'ellipse'   => true // We fill in ellipse or rectangle
];
```

### Save method

```php
Initialatar::save($mixed);
```

#### String

The name of the output image

#### Array

An array with 2 options, An object and his method

```php
$oInitialatar->save(array('CLASS', 'METHOD'));

// This option expect 2 parameter
// $image
// $ressource of image
CLASS::method(Initialatar $initialatar, $ressource);
```

#### Callable

A callable function

```php
$oInitialatar->save(function(Initialatar $initialatar, $ressource) {
    // My code here
});
```

#### Output method

With Array or Callable option, you have to ```$initialatar->put('PATH/TO/FILE/FILENAME.PNG', $initialatar->output());``` to finish execution

```php
use Initialatar\Initialatar;

// Class example
class File {
    public function save(Initialatar $initialatar, $ressource) {
		// We can play with the ressource before save file
        imageflip($ressource, IMG_FLIP_VERTICAL);
		// Save
        $initialatar->put('PATH/TO/MEDIA/FILENAME.png', $initialatar->output());
    }
}
$file = new File();

$o = new Initialatar([
    'name'      => $name,
    'width'     => 150,
    'height'    => 250,
    'ellipse'   => true,
    'font'      => true
]);
// Save with File::save method
$o->create()->save([$file, 'save']);
```

#### Font options

Default, we use 'verdana.ttf' and 21 font size. You can change this options like this.

```php
$o->setFontOptions([
    'font' => FULL_PATH_TO_YOUR_TTF_FONT,
    'size' => 60
]);
```

## LICENCE

The MIT License (MIT)

Copyright (c) 2016 Edouard Tack

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
