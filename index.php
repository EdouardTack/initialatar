<?php

use Initialatar\Initialatar;

include './vendor/autoload.php';

$name = "Edouard Tack";

$o = new Initialatar(array(
    'name'      => $name,
    'width'     => 200,
    'height'    => 200,
));
$o->create()->save('test.png');
