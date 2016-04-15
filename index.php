<?php

use Initialatar\Initialatar;

include './vendor/autoload.php';

$name = "sdouard van dr Tack";

class File {
    public function save(Initialatar $initialatar, $ressource) {
        imageflip($ressource, IMG_FLIP_VERTICAL);
        $initialatar->put('media/test.png', $initialatar->output());
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
$o->create()->save([$file, 'save']);
?>
<!DOCTYPE>
<html>
<head>

</head>
<body class="initial">
    <img src="<?= $o->display(); ?>" alt="<?= $o->getName(); ?>">
</body>
</html>
