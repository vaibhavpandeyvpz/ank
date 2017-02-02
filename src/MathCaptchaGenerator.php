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
 * Class MathCaptchaGenerator
 * @package Ank
 */
class MathCaptchaGenerator extends CaptchaGeneratorAbstract
{
    /**
     * {@inheritdoc}
     */
    public function getCaptcha($id = 'default')
    {
        switch (mt_rand(1, 3)) {
            case 1:
                $lhs = mt_rand(1, 10);
                $rhs = mt_rand(1, 10);
                $operator = '+';
                $answer = $lhs + $rhs;
                break;
            case 2:
                $lhs = mt_rand(11, 20);
                $rhs = mt_rand(1, 10);
                $operator = '-';
                $answer = $lhs - $rhs;
                break;
            default:
                $lhs = mt_rand(1, 9);
                $rhs = mt_rand(2, 5);
                $operator = '*';
                $answer = $lhs * $rhs;
                break;
        }
        $this->storage[$id] = $answer;
        $text = implode(' ', compact('lhs', 'operator', 'rhs'));
        return new CaptchaImage($text);
    }
}
