<?php

use Initialatar\Initialatar;

include './vendor/autoload.php';

$name = "Edouard Tack";

$o = new Initialatar(array(
    'name'      => $name,
    'width'     => 50,
    'height'    => 50,
    'ellipse'   => true
));
$o->create()->save('test.png');

?>
<!DOCTYPE>
<html>
<head>

</head>
<body class="initial">
    <img src="<?php echo $o->display(); ?>" alt="">
</body>
</html>
