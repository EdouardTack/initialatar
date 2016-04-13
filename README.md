# PHP avatar with initial's name

This create an avatar with the first letter of the firstname and name, or with the first letter of one string.

## Requirements

* PHP >= 7

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

$oInitialatar = new Initialatar(array(
    'name'      => "Edouard Tack",
    'width'     => 50,
    'height'    => 50,
    'ellipse'   => true
));

// Create the image ressource
$oInitialatar->create();

// Save to file
$oInitialatar->save('test.png');
```

### Display in your view

```html
<img src="<?php echo $oInitialatar->display(); ?>">
```

## LICENCE

The MIT License (MIT)

Copyright (c) 2016 Edouard

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
