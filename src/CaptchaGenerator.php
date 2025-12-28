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
 * Text-based CAPTCHA generator.
 *
 * Generates random alphanumeric CAPTCHA codes using a character set that
 * excludes easily confused characters (like '0' and 'O', '1' and 'I').
 *
 * @since 1.0.0
 */
final class CaptchaGenerator extends CaptchaGeneratorAbstract
{
    /**
     * Default length of generated CAPTCHA codes.
     */
    protected int $length = 6;

    /**
     * Character set used for generating CAPTCHA codes.
     *
     * Excludes easily confused characters: 0, O, 1, I, J, U, Y, Z
     *
     * @var string
     */
    private const CHARS = '0123456789ABCDEFGHiJKLMNPQRSTVWXYZ';

    /**
     * {@inheritdoc}
     *
     * Generates a random alphanumeric string of the configured length
     * and creates a CAPTCHA image with that text.
     */
    public function getCaptcha(string $id = 'default'): CaptchaImageInterface
    {
        $chars = str_split(self::CHARS);
        $charCount = count($chars);
        $text = '';
        for ($i = 0; $i < $this->length; $i++) {
            $text .= $chars[random_int(0, $charCount - 1)];
        }
        $this->storage[$id] = $text;

        return new CaptchaImage($text);
    }

    /**
     * Sets the length of generated CAPTCHA codes.
     *
     * @param  int  $length  The number of characters in the generated CAPTCHA code.
     *                       Must be a positive integer.
     * @return static Returns self for method chaining.
     */
    public function setLength(int $length): static
    {
        $this->length = $length;

        return $this;
    }
}
