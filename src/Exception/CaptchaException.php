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

namespace Ank\Exception;

/**
 * Base exception class for CAPTCHA-related errors.
 *
 * All exceptions thrown by the CAPTCHA library extend this class,
 * allowing for easy exception handling and type checking.
 *
 * @since 1.0.0
 */
class CaptchaException extends \RuntimeException {}
