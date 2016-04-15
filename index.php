<?php

use Initialatar\Initialatar;

include './vendor/autoload.php';

$name = "sdouard van dr Tack";

$o = new Initialatar([
    'name'      => $name,
    'width'     => 150,
    'height'    => 250,
    'ellipse'   => true,
    'font'      => true
]);
$o->create()->save('true');
?>
<!DOCTYPE>
<html>
<head>

</head>
<body class="initial">
    <img src="<?= $o->display(); ?>" alt="<?= $o->getName(); ?>">
</body>
</html>
