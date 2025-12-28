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

use Ank\Exception\CaptchaException;
use Ank\Exception\ImageGenerationException;
use PHPUnit\Framework\TestCase;

/**
 * Class ExceptionTest
 */
class ExceptionTest extends TestCase
{
    public function test_captcha_exception_extends_runtime_exception(): void
    {
        $exception = new CaptchaException('Test message');

        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('Test message', $exception->getMessage());
    }

    public function test_image_generation_exception_extends_captcha_exception(): void
    {
        $exception = new ImageGenerationException('Test message');

        $this->assertInstanceOf(CaptchaException::class, $exception);
        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('Test message', $exception->getMessage());
    }

    public function test_image_generation_exception_can_be_thrown(): void
    {
        $this->expectException(ImageGenerationException::class);
        $this->expectExceptionMessage('Failed to create image');

        throw new ImageGenerationException('Failed to create image');
    }

    public function test_captcha_exception_can_be_thrown(): void
    {
        $this->expectException(CaptchaException::class);
        $this->expectExceptionMessage('Generic captcha error');

        throw new CaptchaException('Generic captcha error');
    }
}
