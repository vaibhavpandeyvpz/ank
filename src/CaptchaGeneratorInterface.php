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
 * Interface CaptchaGeneratorInterface
 * @package Ank
 */
interface CaptchaGeneratorInterface
{
    /**
     * @param string $id
     * @return CaptchaImageInterface
     */
    public function getCaptcha($id = 'default');

    /**
     * @param string $input
     * @param string $id
     * @return bool
     */
    public function isValid($input, $id = 'default');
}
