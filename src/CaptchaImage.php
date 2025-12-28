<?php

/*
 * This file is part of vaibhavpandeyvpz/ank package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace Ank;

use Ank\Exception\ImageGenerationException;

/**
 * CAPTCHA image generator.
 *
 * Creates and renders CAPTCHA images using PHP's GD library. Supports
 * customization of colors, fonts, size, quality, and text distortion.
 *
 * @since 1.0.0
 */
final class CaptchaImage implements CaptchaImageInterface
{
    /**
     * Background color as RGB array.
     *
     * @var array{r: int, g: int, b: int}
     */
    protected array $background;

    /**
     * Text distortion parameters.
     *
     * First element is maximum rotation angle, second is maximum vertical offset.
     *
     * @var array{0: int, 1: int}
     */
    protected array $distortion = [6, 3];

    /**
     * Font to use for text rendering.
     */
    protected Font $font;

    /**
     * Foreground (text) color as RGB array.
     *
     * @var array{r: int, g: int, b: int}
     */
    protected array $foreground;

    /**
     * JPEG quality for output (0-100).
     */
    protected int $quality = 90;

    /**
     * Image dimensions [width, height] in pixels.
     *
     * @var array{0: int, 1: int}
     */
    protected array $size = [96, 32];

    /**
     * Text to display in the CAPTCHA.
     */
    protected string $text;

    /**
     * Constructor.
     *
     * @param  string  $text  The text to display in the CAPTCHA image.
     * @param  string  $fg  Foreground (text) color in hexadecimal format.
     *                      Defaults to '#121212' (dark gray).
     * @param  string  $bg  Background color in hexadecimal format.
     *                      Defaults to '#efefef' (light gray).
     */
    public function __construct(string $text, string $fg = '#121212', string $bg = '#efefef')
    {
        $this->setText($text);
        $this->setForegroundColor($fg);
        $this->setBackgroundColor($bg);
        $this->setFont(Font::random());
    }

    /**
     * {@inheritdoc}
     *
     * Generates the CAPTCHA image using PHP's GD library. The image is rendered
     * with text distortion (random rotation and offset) to make it harder for
     * bots to read.
     *
     * @throws \Ank\Exception\ImageGenerationException If any GD operation fails,
     *                                                 including image creation, color
     *                                                 allocation, or output generation.
     */
    public function getImage(): string
    {
        [$width, $height] = $this->size;
        $image = imagecreatetruecolor($width, $height);
        if ($image === false) {
            throw new ImageGenerationException('Failed to create image');
        }

        // Fill
        $bg = imagecolorallocate($image, $this->background['r'], $this->background['g'], $this->background['b']);
        if ($bg === false) {
            imagedestroy($image);
            throw new ImageGenerationException('Failed to allocate background color');
        }
        imagefilledrectangle($image, 0, 0, $width, $height, $bg);

        // Write
        $fg = imagecolorallocate($image, $this->foreground['r'], $this->foreground['g'], $this->foreground['b']);
        if ($fg === false) {
            imagedestroy($image);
            throw new ImageGenerationException('Failed to allocate foreground color');
        }

        $length = strlen($this->text);
        if ($length === 0) {
            $length = 1; // Prevent division by zero
        }
        $size = (int) (($width / $length) - (random_int(0, 3) - 1));
        $fontPath = $this->font->getPath();
        $box = imagettfbbox($size, 0, $fontPath, $this->text);
        if ($box === false) {
            imagedestroy($image);
            throw new ImageGenerationException('Failed to get text bounding box');
        }

        $w = $box[2] - $box[0];
        $h = $box[1] - $box[7];
        $x = (int) (($width - $w) / 2);
        $y = (int) ((($height - $h) / 2) + $size);

        [$baseAngle, $baseOffset] = $this->distortion;
        for ($i = 0; $i < $length; $i++) {
            $box = imagettfbbox($size, 0, $fontPath, $this->text[$i]);
            if ($box === false) {
                continue;
            }
            $w2 = $box[2] - $box[0];
            $angle = random_int(-$baseAngle, $baseAngle);
            $offset = random_int(-$baseOffset, $baseOffset);
            imagettftext($image, $size, $angle, $x, $y + $offset, $fg, $fontPath, $this->text[$i]);
            $x += $w2;
        }

        // Output
        ob_start();
        $success = imagejpeg($image, null, $this->quality);
        $data = ob_get_clean();
        imagedestroy($image);

        if (! $success || $data === false) {
            throw new ImageGenerationException('Failed to generate image output');
        }

        return $data;
    }

    /**
     * Converts a hexadecimal color string to RGB array.
     *
     * Supports both 3-digit (#FFF) and 6-digit (#FFFFFF) hex formats.
     * The '#' prefix is optional.
     *
     * @param  string  $hex  Hexadecimal color string (with or without '#' prefix).
     * @return array{r: int, g: int, b: int} RGB color array with 'r', 'g', 'b' keys.
     */
    protected static function getRgbFromHex(string $hex): array
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) === 3) {
            $r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        return ['r' => $r, 'g' => $g, 'b' => $b];
    }

    /**
     * {@inheritdoc}
     *
     * @param  string  $hex  Color in hexadecimal format (e.g., '#FFFFFF' or 'FFFFFF').
     */
    public function setBackgroundColor(string $hex): static
    {
        $this->background = self::getRgbFromHex($hex);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param  int  $angle  Maximum rotation angle in degrees.
     * @param  int  $offset  Maximum vertical offset in pixels.
     */
    public function setDistortion(int $angle, int $offset): static
    {
        $this->distortion = [$angle, $offset];

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param  Font  $font  The font enum value to use.
     */
    public function setFont(Font $font): static
    {
        $this->font = $font;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param  string  $hex  Color in hexadecimal format (e.g., '#000000' or '000000').
     */
    public function setForegroundColor(string $hex): static
    {
        $this->foreground = self::getRgbFromHex($hex);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param  int  $quality  JPEG quality from 0 to 100.
     */
    public function setQuality(int $quality): static
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param  int  $width  Image width in pixels.
     * @param  int  $height  Image height in pixels.
     */
    public function setSize(int $width, int $height): static
    {
        $this->size = [$width, $height];

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param  string  $text  The text string to display.
     */
    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    /**
     * String representation of the CAPTCHA image.
     *
     * Returns the image data when cast to string. If image generation fails,
     * returns an empty string instead of throwing an exception.
     *
     * @return string The JPEG image data, or empty string on failure.
     */
    public function __toString(): string
    {
        try {
            return $this->getImage();
        } catch (ImageGenerationException) {
            return '';
        }
    }
}
