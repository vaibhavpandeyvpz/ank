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
 * Exception thrown when CAPTCHA image generation fails.
 *
 * This exception is thrown when any step of the image generation process
 * fails, including:
 * - Image resource creation
 * - Color allocation
 * - Font/text bounding box calculation
 * - Image output generation
 *
 * @since 1.0.0
 */
class ImageGenerationException extends CaptchaException {}
