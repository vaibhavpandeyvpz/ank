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
 * Interface CaptchaImageInterface
 * @package Ank
 */
interface CaptchaImageInterface
{
    /**
     * @return string
     */
    public function getImage();

    /**
     * @param string $hex
     * @return static
     */
    public function setBackgroundColor($hex);

    /**
     * @param int $angle
     * @param int $offset
     * @return static
     */
    public function setDistortion($angle, $offset);

    /**
     * @param string $name
     * @return static
     */
    public function setFont($name);

    /**
     * @param string $hex
     * @return static
     */
    public function setForegroundColor($hex);

    /**
     * @param int $quality
     * @return static
     */
    public function setQuality($quality);

    /**
     * @param int $width
     * @param int $height
     * @return static
     */
    public function setSize($width, $height);

    /**
     * @param string $text
     * @return static
     */
    public function setText($text);
}
