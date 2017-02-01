<?php

/*
 * This file is part of vaibhavpandeyvpz/ank package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

namespace Ank;

/**
 * Class CaptchaImage
 * @package Ank
 */
class CaptchaImage implements CaptchaImageInterface
{
    const FONT_ACME = 'Acme-Regular';

    const FONT_BANGERS = 'Bangers-Regular';

    const FONT_BARRIO = 'Barrio-Regular';

    const FONT_BREE_SERIF = 'BreeSerif-Regular';

    const FONT_FRECKLE_FACE = 'FreckleFace-Regular';

    const FONT_GOCHI_HAND = 'GochiHand-Regular';

    const FONT_LUCKIEST_GUY = 'LuckiestGuy-Regular';

    const FONT_PANGOLIN = 'Pangolin-Regular';

    const FONT_RALEWAY = 'Raleway-Regular';

    const FONT_RIGHTEOUS = 'Righteous-Regular';

    const FONT_ROBOTO_SLAB = 'RobotoSlab-Regular';

    const FONT_SANSITA = 'Sansita-Regular';

    /**
     * @var array
     */
    protected $background;

    /**
     * @var array
     */
    protected $distortion = array(6, 3);

    /**
     * @var string
     */
    protected $font;

    /**
     * @var array
     */
    protected static $fonts = array(
        self::FONT_ACME,
        self::FONT_BANGERS,
        self::FONT_BARRIO,
        self::FONT_BREE_SERIF,
        self::FONT_FRECKLE_FACE,
        self::FONT_GOCHI_HAND,
        self::FONT_LUCKIEST_GUY,
        self::FONT_PANGOLIN,
        self::FONT_RALEWAY,
        self::FONT_RIGHTEOUS,
        self::FONT_ROBOTO_SLAB,
        self::FONT_SANSITA,
    );

    /**
     * @var array
     */
    protected $foreground;

    /**
     * @var int
     */
    protected $quality = 90;

    /**
     * @var array
     */
    protected $size = array(96, 32);

    /**
     * @var string
     */
    protected $text;

    /**
     * CaptchaImage constructor.
     * @param string $text
     * @param string $fg
     * @param string $bg
     */
    public function __construct($text, $fg = '#121212', $bg = '#efefef')
    {
        $this->setText($text);
        $this->setForegroundColor($fg);
        $this->setBackgroundColor($bg);
        $i = array_rand(self::$fonts);
        $this->setFont(self::$fonts[$i]);
    }

    /**
     * {@inheritdoc}
     */
    public function getImage()
    {
        list($width, $height) = $this->size;
        $image = imagecreatetruecolor($width, $height);
        // Fill
        $bg = imagecolorallocate($image, $this->background['r'], $this->background['g'], $this->background['b']);
        imagefilledrectangle($image, 0, 0, $width, $height, $bg);
        // Write
        $fg = imagecolorallocate($image, $this->foreground['r'], $this->foreground['g'], $this->foreground['b']);
        $length = strlen($this->text);
        $size = ($width / $length) - (mt_rand(0, 3) - 1);
        $font = sprintf('%s/../fonts/%s.ttf', __DIR__, $this->font);
        $box = imagettfbbox($size, 0, $font, $this->text);
        $w = $box[2] - $box[0];
        $h = $box[1] - $box[7];
        $x = ($width - $w) / 2;
        $y = (($height - $h) / 2) + $size;
        for ($i = 0; $i < $length; $i++) {
            $box = imagettfbbox($size, 0, $font, $this->text[$i]);
            $w2 = $box[2] - $box[0];
            list($angle, $offset) = $this->distortion;
            $angle = mt_rand(-$angle, $angle);
            $offset = mt_rand(-$offset, $offset);
            imagettftext($image, $size, $angle, $x, $y + $offset, $fg, $font, $this->text[$i]);
            $x += $w2;
        }
        // Output
        ob_start();
        imagejpeg($image, null, $this->quality);
        $data = ob_get_clean();
        imagedestroy($image);
        return $data;
    }

    /**
     * @param string $hex
     * @return array
     */
    protected static function getRgbFromHex($hex)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return compact('r', 'g', 'b');
    }

    /**
     * {@inheritdoc}
     */
    public function setBackgroundColor($hex)
    {
        $this->background = self::getRgbFromHex($hex);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDistortion($angle, $offset)
    {
        $this->distortion = array($angle, $offset);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setFont($name)
    {
        $this->font = $name;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setForegroundColor($hex)
    {
        $this->foreground = self::getRgbFromHex($hex);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSize($width, $height)
    {
        $this->size = array($width, $height);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        try {
            return $this->getImage();
        } catch (\Exception $e) {
        }
        return '';
    }
}
