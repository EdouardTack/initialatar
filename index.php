<?php

use Initialatar\Initialatar;

include './vendor/autoload.php';

$name = "sdouard van dr Tack";

$o = new Initialatar(array(
    'name'      => $name,
    'width'     => 200,
    'height'    => 200,
    'ellipse'   => false,
    'font'      => true
));
$o->create()->save('true');

?>
<!DOCTYPE>
<html>
<head>

</head>
<body class="initial">
    <img src="<?php echo $o->display(); ?>" alt="">
</body>
</html>
