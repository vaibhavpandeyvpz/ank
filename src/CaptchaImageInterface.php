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

/**
 * Interface CaptchaImageInterface
 *
 * Defines the contract for CAPTCHA image objects. Provides methods to customize
 * the appearance and generate the final image output.
 *
 * @since 1.0.0
 */
interface CaptchaImageInterface
{
    /**
     * Generates and returns the CAPTCHA image as JPEG binary data.
     *
     * @return string The JPEG image data as a binary string. Can be directly output
     *                to the browser with appropriate Content-Type header.
     *
     * @throws \Ank\Exception\ImageGenerationException If image generation fails due
     *                                                 to GD library errors or resource
     *                                                 allocation failures.
     */
    public function getImage(): string;

    /**
     * Sets the background color of the CAPTCHA image.
     *
     * @param  string  $hex  Color in hexadecimal format (e.g., '#FFFFFF' or 'FFFFFF').
     *                       Supports both 3-digit (#FFF) and 6-digit (#FFFFFF) formats.
     * @return static Returns self for method chaining.
     */
    public function setBackgroundColor(string $hex): static;

    /**
     * Sets the text distortion parameters for the CAPTCHA.
     *
     * Distortion makes the text harder for bots to read while remaining readable
     * for humans. Each character is randomly rotated and offset within the specified
     * ranges.
     *
     * @param  int  $angle  Maximum rotation angle in degrees. Characters will be rotated
     *                      randomly between -$angle and +$angle.
     * @param  int  $offset  Maximum vertical offset in pixels. Characters will be offset
     *                       randomly between -$offset and +$offset.
     * @return static Returns self for method chaining.
     */
    public function setDistortion(int $angle, int $offset): static;

    /**
     * Sets the font to use for rendering the CAPTCHA text.
     *
     * @param  Font  $font  The font enum value to use for text rendering.
     * @return static Returns self for method chaining.
     */
    public function setFont(Font $font): static;

    /**
     * Sets the foreground (text) color of the CAPTCHA image.
     *
     * @param  string  $hex  Color in hexadecimal format (e.g., '#000000' or '000000').
     *                       Supports both 3-digit (#000) and 6-digit (#000000) formats.
     * @return static Returns self for method chaining.
     */
    public function setForegroundColor(string $hex): static;

    /**
     * Sets the JPEG quality for the output image.
     *
     * @param  int  $quality  JPEG quality from 0 to 100, where 100 is the highest quality.
     *                        Higher quality results in larger file sizes.
     * @return static Returns self for method chaining.
     */
    public function setQuality(int $quality): static;

    /**
     * Sets the dimensions of the CAPTCHA image.
     *
     * @param  int  $width  The width of the image in pixels.
     * @param  int  $height  The height of the image in pixels.
     * @return static Returns self for method chaining.
     */
    public function setSize(int $width, int $height): static;

    /**
     * Sets the text to display in the CAPTCHA image.
     *
     * @param  string  $text  The text string to render in the CAPTCHA.
     * @return static Returns self for method chaining.
     */
    public function setText(string $text): static;
}
