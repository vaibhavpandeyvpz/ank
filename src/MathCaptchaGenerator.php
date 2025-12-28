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
 * Mathematics-based CAPTCHA generator.
 *
 * Generates simple arithmetic problems (addition, subtraction, multiplication)
 * that users must solve. This type of CAPTCHA is more accessible than text-based
 * CAPTCHAs as it doesn't require reading distorted text.
 *
 * @since 1.0.0
 */
final class MathCaptchaGenerator extends CaptchaGeneratorAbstract
{
    /**
     * {@inheritdoc}
     *
     * Generates a random math problem and creates a CAPTCHA image displaying
     * the problem. The answer is stored for validation.
     *
     * Problem types:
     * - Addition: Two numbers between 1-10
     * - Subtraction: Minuend 11-20, subtrahend 1-10 (ensures positive result)
     * - Multiplication: Multiplier 1-9, multiplicand 2-5
     */
    public function getCaptcha(string $id = 'default'): CaptchaImageInterface
    {
        $result = match (random_int(1, 3)) {
            1 => [
                'lhs' => random_int(1, 10),
                'rhs' => random_int(1, 10),
                'operator' => '+',
            ],
            2 => [
                'lhs' => random_int(11, 20),
                'rhs' => random_int(1, 10),
                'operator' => '-',
            ],
            default => [
                'lhs' => random_int(1, 9),
                'rhs' => random_int(2, 5),
                'operator' => '*',
            ],
        };

        $answer = match ($result['operator']) {
            '+' => $result['lhs'] + $result['rhs'],
            '-' => $result['lhs'] - $result['rhs'],
            '*' => $result['lhs'] * $result['rhs'],
        };

        $this->storage[$id] = $answer;
        $text = sprintf('%d %s %d', $result['lhs'], $result['operator'], $result['rhs']);

        return new CaptchaImage($text);
    }
}
