<?php

use Initialatar\Initialatar;

include './vendor/autoload.php';

class File {
 public function metho($image, $ressource) {
    die('test');
 }
}

$name = "Edouard Tack";

$o = new Initialatar(array(
    'name'      => $name,
    'width'     => 50,
    'height'    => 50,
    'ellipse'   => true
));
$o->create()->save(array(new File(), 'metho'));

?>
<!DOCTYPE>
<html>
<head>

</head>
<body class="initial">
    <img src="<?php echo $o->display(); ?>" alt="">
</body>
</html>
