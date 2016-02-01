<?php


namespace Initialatar;


/**
 *
 * @property array _params
 * @property array _params
 * @property array _params
 */
class Initialatar {

    /** @var array  */
    private $_params = array();

    /** @var array  */
    private $_ressource;

    /** @var array  */
    private $image;

    /**
     * @param array $params
     */
    public function __construct(array $params = array()) {
        $default = array(
            'width'     => 100,
            'height'    => 100,
        );

        $this->_params = $params + $default;
    }

    /**
     *
     */
    public function create() {
        $this->_createImage();

        return $this;
    }

    /**
     *
     */
    public function display() {
        header('Content-type: image/png');
        echo($this->image);
    }

    /**
     * @param $filename
     * @return mixed
     */
    public function save(string $filename) {
        if (file_put_contents($filename, $this->image)) {
            return $filename;
        }
    }

    /**
     *
     */
    private function _createImage() {
        $hash = md5($this->_params['name']);
        $color = substr($hash, 0, 6);
        $image = imagecreatetruecolor($this->_params['width'], $this->_params['height']);

        $bg = imagecolorallocate($image, 0, 0, 0);
        imagecolortransparent($image, $bg);

        $color = imagecolorallocate($image, hexdec(substr($color,0,2)), hexdec(substr($color,2,2)), hexdec(substr($color,4,2)));
        imagefilledellipse($image, ($this->_params['width'] / 2), ($this->_params['height'] / 2), $this->_params['width'], $this->_params['height'], $color);

        $name = explode(' ', $this->_params['name']);
        $textcolor = imagecolorallocate($image, 255, 255, 255);
        imagestring($image, 5, ($this->_params['width'] / 2), ($this->_params['height'] / 2), substr($name[0], 0, 1) . substr($name[1], 0, 1), $textcolor);

        ob_start();
        $this->_ressource = imagepng($image);
        $image_data = ob_get_contents();
        ob_end_clean();
        $this->image = $image_data;
    }

}
