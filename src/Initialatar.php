<?php
/**
 * Initialatar library
 *
 * @author Edouard Tack <edouard@tackacoder.fr>
 * @version Initialatar main version 1.0
 * @license Licensed under MIT (https://github.com/EdouardTack/initialatar/blob/master/LICENSE)
 */

namespace Initialatar;

/**
 * Initialatar
 *
 * @property string $filename
 * @property array $_params
 * @property array $_ressource
 * @property array $_image
 * @property string $_filename
 * @property array $_fontOptions
 */
class Initialatar {

    /** @var string */
    public $filename;

    /** @var array */
    private $_params = [];

    /** @var array */
    private $_ressource;

    /** @var string */
    private $_image;

    /** @var string */
    private $_filename;

    /** @var array */
    private $_fontOptions = [
        'font' => 'verdana.ttf',
        'size' => 21
    ];

    /**
     * Constructor
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $default = [
            'width'     => 100,
            'height'    => 100,
            'ellipse'   => true,
            'font'      => false
        ];

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
     *
     */
    public function getName(): string
    {
        if (!is_null($this->filename))
            return basename($this->filename);

        return basename($this->_filename);
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
    public function save($mixed): Initialatar
    {
        if (is_string($mixed)) {
            if (strpos($mixed, '.png') === false)
                $mixed .= ".png";
            if (file_put_contents($mixed, $this->_image)) {
                $this->_filename = $mixed;
            }
        }
        else if (is_array($mixed)) {
            list($object, $method) = $mixed;

            // if (is_a($object, get_class($object))) {
                $this->filename = call_user_func_array($mixed, [$this->_image, $this->_ressource]);
            /*}
            else if (class_exists($object)) {
                $this->filename = $object::$method($this->_image, $this->_ressource);
            }*/
        }
        else if (is_callable($mixed)) {
            $this->filename = $mixed($this->_image, $this->_ressource);
        }

        return $this;
    }

    /**
     * define other options to font
     *
     * @param array $options
     *   -- font the path to ttf font
     *   -- size int the size of font text
     *
     * @return void
     */
    public function setFontOptions(array $options): Initialatar
    {
        $this->_fontOptions = $this->_fontOptions + $options;

        return $this;
    }

    /**
     * Create the initials with the name parameter
     *
     * @return string
     */
    private function _setName(): string
    {
        $return = [];
        $names = explode(' ', $this->_params['name']);
        foreach ($names as $name) {
            $return[] = (string) mb_substr(mb_strtoupper($name), 0, 1);
        }

        return implode('', $return);
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

        $bgColor = imagecolorallocate($this->_ressource, hexdec(substr($color, 0, 2)), hexdec(substr($color, 2, 2)), hexdec(substr($color, 4, 2)));

        if ($this->_params['ellipse'])
            imagefilledellipse($this->_ressource, ($this->_params['width'] / 2), ($this->_params['height'] / 2), $this->_params['width'] - 1, $this->_params['height'] - 1, $bgColor);
        else
            imagefilledrectangle($this->_ressource, 0, 0, $this->_params['width'], $this->_params['height'], $bgColor);

        list($red, $green, $blue) = $this->_getContrast($color);
        $textcolor = imagecolorallocate($this->_ressource, $red, $green, $blue);
        $this->_setFont($textcolor);

        ob_start();
        $this->_ressource = imagepng($this->_ressource);
        $image_data = ob_get_contents();
        ob_end_clean();
        $this->_image = $image_data;
    }

    /**
     * Apply the text on the image ressource
     *
     * @param $color int The color code send by imagecolorallocate()
     *
     * @return void
     */
    private function _setFont(int $color)
    {
        $name = $this->_setName();

        if ($this->_params['font']) {
            if ($this->_fontOptions['font'] === 'verdana.ttf') {
                $this->_fontOptions['font'] = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'font' . DIRECTORY_SEPARATOR . $this->_fontOptions['font'];
            }
            // Get the coords for font positioning
            $bbox = imagettfbbox($this->_fontOptions['size'], 0, $this->_fontOptions['font'], $name);
            $x = $bbox[0] + (imagesx($this->_ressource) / 2) - ($bbox[4] / 2);
            $y = $bbox[1] + (imagesy($this->_ressource) / 2) - ($bbox[5] / 2);
            // Add the font text
            imagettftext($this->_ressource, $this->_fontOptions['size'], 0, $x, $y, $color, $this->_fontOptions['font'], $name);
        }
        else {
            list($x, $y) = $this->_getTextPosition($name, $color);
            imagestring($this->_ressource, 5, $x, $y, $name, $color);
        }
    }

    /**
     * Setting the text in image
     *
     * @param string $text
     *
     * @return array
     */
    private function _getTextPosition(string $text): array
    {
        $font = 12;

        $fontWidth = imagefontwidth($font);
        $fontHeight = imagefontheight($font);

        $textWidth = $fontWidth * strlen($text);
        $positionCenter = (($this->_params['width'] - $textWidth) / 2);

        $textHeight = $fontHeight;
        $positionMiddle = (($this->_params['height'] - $textHeight) / 2);

        return [$positionCenter, $positionMiddle];
    }

    /**
     * Get rgb color by contrast of the background color
     *
     * @param string $hexcolor hexadecimal background color
     *
     * @return array the rgb id
     */
    private function _getContrast(string $color): array
    {
        $hexcolor = substr($color, 0, 6);
        $r = hexdec(substr($hexcolor, 0, 2));
        $g = hexdec(substr($hexcolor, 2, 2));
        $b = hexdec(substr($hexcolor, 4, 2));

        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

        return ($yiq >= 128) ? [1, 1, 1] : [255, 255, 255];
    }

}
