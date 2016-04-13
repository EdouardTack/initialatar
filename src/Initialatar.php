<?php

namespace Initialatar;

/**
 * Initialatar
 * @property array $_params
 * @property array $_ressource
 * @property array $image
 */
class Initialatar {

    /** @var string */
    public $filename;

    /** @var array */
    private $_params = array();

    /** @var array */
    private $_ressource;

    /** @var array */
    private $_image;

    /** @var string */
    private $_filename;

    /**
     * Constructor
     *
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        $default = array(
            'width'     => 100,
            'height'    => 100,
            'ellipse'   => true
        );

        $this->_params = $params + $default;
    }

    /**
     * Create the initialatar image
     *
     * @return \Initialatar
     */
    public function create(): Initialatar
    {
        $this->_createImage();

        return $this;
    }

    /**
     * Return the file name to display
     *
     * @return string
     */
    public function display(): string
    {
        if (!is_null($this->filename))
            return $this->filename;

        return $this->_filename;
    }

    /**
     * Saving the initialar image
     *
     * @param mixed
     *   -- string
     *   -- array with Object and method
     *   -- callable
     *
     * @return void
     */
    public function save($mixed)
    {
        if (is_string($mixed)) {
            if (file_put_contents($mixed, $this->_image)) {
                $this->_filename = $mixed;
            }
        }
        else if (is_array($mixed)) {
            list($object, $method) = $mixed;

            if (is_a($object, get_class($object))) {
                $this->filename = call_user_func_array($mixed, array($this->_image, $this->_ressource));
            }
            else if (class_exists($object)) {
                $this->filename = $object::$method($this->_image, $this->_ressource);
            }
        }
        else if (is_callable($mixed)) {
            $this->filename = $mixed($this->_image, $this->_ressource);
        }
    }

    /**
     * Create the initialar image
     *
     * @return void
     */
    private function _createImage()
    {
        $hash = md5($this->_params['name']);
        $color = substr($hash, 0, 6);
        $this->_ressource = imagecreatetruecolor($this->_params['width'], $this->_params['height']);

        imageantialias($this->_ressource, true);
        imagesetthickness($this->_ressource, 25);

        $bg = imagecolorallocate($this->_ressource, 0, 0, 0);
        imagecolortransparent($this->_ressource, $bg);

        $color = imagecolorallocate($this->_ressource, hexdec(substr($color,0,2)), hexdec(substr($color,2,2)), hexdec(substr($color,4,2)));

        if ($this->_params['ellipse'])
            imagefilledellipse($this->_ressource, ($this->_params['width'] / 2), ($this->_params['height'] / 2), $this->_params['width'] - 1, $this->_params['height'] - 1, $color);
        else
            imagefilledrectangle($this->_ressource, 0, 0, $this->_params['width'], $this->_params['height'], $color);

        $name = explode(' ', $this->_params['name']);
        $name = (string) substr($name[0], 0, 1) . substr($name[1], 0, 1);
        $textcolor = imagecolorallocate($this->_ressource, 255, 255, 255);
        list($x, $y) = $this->_setFont($name, $textcolor);
        imagestring($this->_ressource, 5, $x, $y, $name, $textcolor);

        ob_start();
        $this->_ressource = imagepng($this->_ressource);
        $image_data = ob_get_contents();
        ob_end_clean();
        $this->_image = $image_data;
    }

    /**
     * Setting the text in image
     *
     * @param string $text
     * @param $textcolor
     *
     * @return array
     */
    private function _setFont(string $text): array
    {
        $font = 8;

        $fontWidth = imagefontwidth($font);
        $fontHeight = imagefontheight($font);

        $textWidth = $fontWidth * strlen($text);
        $positionCenter = (($this->_params['width'] - $textWidth) / 2);

        $textHeight = $fontHeight;
        $positionMiddle = (($this->_params['height'] - $textHeight) / 2);

        return array($positionCenter, $positionMiddle);
    }

}
