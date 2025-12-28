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

use PHPUnit\Framework\TestCase;

/**
 * Class CaptchaGeneratorAbstractTest
 */
class CaptchaGeneratorAbstractTest extends TestCase
{
    public function test_constructor_with_null_storage_uses_session(): void
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Clear any existing data
        unset($_SESSION[CaptchaGeneratorAbstract::STORAGE_KEY]);

        // Pass null by reference
        $storage = null;
        $generator = new CaptchaGenerator($storage);

        $this->assertArrayHasKey(CaptchaGeneratorAbstract::STORAGE_KEY, $_SESSION);
        $this->assertIsArray($_SESSION[CaptchaGeneratorAbstract::STORAGE_KEY]);
    }

    public function test_constructor_with_empty_storage_array(): void
    {
        $storage = [];
        $generator = new CaptchaGenerator($storage);

        $this->assertArrayHasKey(CaptchaGeneratorAbstract::STORAGE_KEY, $storage);
        $this->assertIsArray($storage[CaptchaGeneratorAbstract::STORAGE_KEY]);
    }

    public function test_constructor_with_storage_missing_key(): void
    {
        $storage = ['other_key' => 'value'];
        $generator = new CaptchaGenerator($storage);

        $this->assertArrayHasKey(CaptchaGeneratorAbstract::STORAGE_KEY, $storage);
        $this->assertIsArray($storage[CaptchaGeneratorAbstract::STORAGE_KEY]);
    }

    public function test_constructor_with_storage_not_array(): void
    {
        $storage = [CaptchaGeneratorAbstract::STORAGE_KEY => 'not_an_array'];
        $generator = new CaptchaGenerator($storage);

        $this->assertIsArray($storage[CaptchaGeneratorAbstract::STORAGE_KEY]);
    }

    public function test_constructor_with_existing_storage_array(): void
    {
        $storage = [
            CaptchaGeneratorAbstract::STORAGE_KEY => ['existing' => 'data'],
        ];
        $generator = new CaptchaGenerator($storage);

        $this->assertArrayHasKey('existing', $storage[CaptchaGeneratorAbstract::STORAGE_KEY]);
        $this->assertEquals('data', $storage[CaptchaGeneratorAbstract::STORAGE_KEY]['existing']);
    }
}
