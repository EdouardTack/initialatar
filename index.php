<?php

use Initialatar\Initialatar;

include './vendor/autoload.php';

$name = "sdouardandrTack";

class File {
    public function save(Initialatar $initialatar, $ressource) {
        imageflip($ressource, IMG_FLIP_VERTICAL);
        $initialatar->put('media/test.png', $initialatar->output());
    }
}
$file = new File();

$o = new Initialatar([
    'name'      => $name,
    'width'     => 50,
    'height'    => 50,
    'ellipse'   => true,
    'font'      => true
]);
$o->setFontOptions(['size' => 12]);
$o->create()->save('test.png');
?>
<!DOCTYPE>
<html>
<head>

</head>
<body class="initial">
    <img src="<?= $o->display(); ?>" alt="<?= $o->getName(); ?>">
</body>
</html>
