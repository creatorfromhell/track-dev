<?php
/**
 * Created by Daniel Vidmar.
 * Date: 8/7/14
 * Time: 12:22 PM
 * Version: Beta 1
 * Last Modified: 8/7/14 at 1:10 PM
 * Last Modified by Daniel Vidmar.
 */
/**
 * Class Captcha
 */
class Captcha {
    /**
     * @var null|string
     */
    public $code = null;
    /**
     * @var null
     */
    public $image = null;

    /**
     * @param null $code
     */
    function __construct($code = null) {
        $this->code = ($code !== null) ? $code : $this->generate_code();
        $this->generate_image();
    }

    /**
     * @return string
     */
    public function generate_code() {
        $valid_chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+123456789";
        $c = "";
        for($i = 0; $i < 6; $i++) {
            $c .= $valid_chars[rand(0, strlen($valid_chars) - 1)];
        }
        return $c;
    }

    /**
     *
     */
    public function generate_image() {
        if($this->code === null) {
            $this->code = $this->generate_code();
        }
        $this->image = imagecreate(95, 35);
        $colorText = imagecolorallocate($this->image, 255, 255, 255);
        $colorBG = imagecolorallocate($this->image, 82, 139, 185);
        $colorRect = imagecolorallocate($this->image, 163, 163, 163);
        imagefill($this->image, 0, 0, $colorBG);
        imagestring($this->image, 10, 20, 10, $this->code, $colorText);
        imageline($this->image, 20, 12, 38, 20, $colorRect);
        imageline($this->image, 50, 15, 80, 15, $colorRect);
        imageline($this->image, 70, 0, 30, 35, $colorRect);
    }

    /**
     * @return string
     */
    public function get_base64() {
        ob_start();
        imagejpeg($this->image, NULL, 100);
        $bytes = ob_get_clean();
        return base64_encode($bytes);
    }

    /**
     * @deprecated return_image() should be used instead since we now have templating support
     */
    public function print_image() {
        echo "<img id='captcha_image' src='data:image/jpeg;base64,".$this->get_base64()."' />";
    }

    /**
     * @return string
     */
    public function return_image() {
        return "<img id='captcha_image' src='data:image/jpeg;base64,".$this->get_base64()."' />";
    }
}