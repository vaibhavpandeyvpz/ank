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
 * Interface CaptchaGeneratorInterface
 *
 * Defines the contract for CAPTCHA generators. Implementations must be able to
 * generate CAPTCHA images and validate user input against stored values.
 *
 * @since 1.0.0
 */
interface CaptchaGeneratorInterface
{
    /**
     * Generates a new CAPTCHA image and stores the answer for validation.
     *
     * @param  string  $id  Optional identifier for the CAPTCHA instance. Allows multiple
     *                      CAPTCHAs to be generated and validated independently.
     *                      Defaults to 'default'.
     * @return CaptchaImageInterface The generated CAPTCHA image object that can be
     *                               customized and rendered.
     */
    public function getCaptcha(string $id = 'default'): CaptchaImageInterface;

    /**
     * Validates user input against the stored CAPTCHA answer.
     *
     * This method performs a one-time validation. After validation (successful or not),
     * the stored value is removed to prevent replay attacks.
     *
     * @param  string  $input  The user-provided answer to validate.
     * @param  string  $id  The identifier of the CAPTCHA instance to validate against.
     *                      Must match the ID used when generating the CAPTCHA.
     *                      Defaults to 'default'.
     * @return bool True if the input matches the stored answer, false otherwise.
     *              Also returns false if the CAPTCHA ID doesn't exist or has already
     *              been validated.
     */
    public function isValid(string $input, string $id = 'default'): bool;
}
