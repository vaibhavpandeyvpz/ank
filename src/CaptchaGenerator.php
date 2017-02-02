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
 * Class CaptchaGenerator
 * @package Ank
 */
class CaptchaGenerator extends CaptchaGeneratorAbstract
{
    /**
     * @var int
     */
    protected $length = 6;

    /**
     * {@inheritdoc}
     */
    public function getCaptcha($id = 'default')
    {
        $chars = str_split('0123456789ABCDEFGHiJKLMNPQRSTVWXYZ');
        $text = '';
        for ($i = 0; $i < $this->length; $i++) {
            $text .= $chars[array_rand($chars)];
        }
        $this->storage[$id] = $text;
        return new CaptchaImage($text);
    }

    /**
     * @param int $length
     * @return static
     */
    public function setLength($length)
    {
        $this->length = $length;
        return $this;
    }
}
