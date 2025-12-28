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
 * Class CaptchaGeneratorTest
 */
class CaptchaGeneratorTest extends TestCase
{
    private array $storage;

    protected function setUp(): void
    {
        $this->storage = [];
    }

    public function test_get_captcha_returns_captcha_image_interface(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $image = $generator->getCaptcha();

        $this->assertInstanceOf(CaptchaImageInterface::class, $image);
    }

    public function test_get_captcha_generates_random_text(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $image1 = $generator->getCaptcha('test1');
        $image2 = $generator->getCaptcha('test2');

        // Verify different captchas are generated
        $this->assertNotEquals($image1, $image2);
    }

    public function test_get_captcha_stores_value_in_storage(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $generator->getCaptcha('test_id');

        $this->assertArrayHasKey('test_id', $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]);
    }

    public function test_get_captcha_generates_correct_length(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $generator->setLength(8);
        $generator->getCaptcha('test');

        $stored = $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]['test'];
        $this->assertEquals(8, strlen($stored));
    }

    public function test_get_captcha_uses_default_id(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $generator->getCaptcha();

        $this->assertArrayHasKey('default', $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]);
    }

    public function test_get_captcha_uses_custom_id(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $generator->getCaptcha('custom_id');

        $this->assertArrayHasKey('custom_id', $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]);
    }

    public function test_is_valid_returns_true_for_correct_input(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $generator->getCaptcha('test');

        $stored = $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]['test'];
        $result = $generator->isValid($stored, 'test');

        $this->assertTrue($result);
    }

    public function test_is_valid_returns_false_for_incorrect_input(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $generator->getCaptcha('test');

        $result = $generator->isValid('wrong_input', 'test');

        $this->assertFalse($result);
    }

    public function test_is_valid_returns_false_for_non_existent_id(): void
    {
        $generator = new CaptchaGenerator($this->storage);

        $result = $generator->isValid('any_input', 'non_existent');

        $this->assertFalse($result);
    }

    public function test_is_valid_removes_value_after_validation(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $generator->getCaptcha('test');
        $stored = $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]['test'];

        $generator->isValid($stored, 'test');

        $this->assertArrayNotHasKey('test', $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]);
    }

    public function test_is_valid_uses_default_id(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $generator->getCaptcha();

        $stored = $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]['default'];
        $result = $generator->isValid($stored);

        $this->assertTrue($result);
    }

    public function test_set_length_returns_self(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $result = $generator->setLength(10);

        $this->assertSame($generator, $result);
    }

    public function test_set_length_changes_generated_length(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $generator->setLength(12);
        $generator->getCaptcha('test');

        $stored = $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]['test'];
        $this->assertEquals(12, strlen($stored));
    }

    public function test_multiple_captchas_with_different_ids(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $generator->getCaptcha('id1');
        $generator->getCaptcha('id2');
        $generator->getCaptcha('id3');

        $this->assertCount(3, $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]);
        $this->assertArrayHasKey('id1', $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]);
        $this->assertArrayHasKey('id2', $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]);
        $this->assertArrayHasKey('id3', $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]);
    }

    public function test_generated_text_contains_only_valid_characters(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $generator->getCaptcha('test');

        $stored = $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]['test'];
        $validChars = str_split('0123456789ABCDEFGHiJKLMNPQRSTVWXYZ');

        foreach (str_split($stored) as $char) {
            $this->assertContains($char, $validChars);
        }
    }

    public function test_is_valid_is_case_sensitive(): void
    {
        $generator = new CaptchaGenerator($this->storage);
        $generator->getCaptcha('test');

        $stored = $this->storage[CaptchaGeneratorAbstract::STORAGE_KEY]['test'];
        $lowercase = strtolower($stored);

        // Only test if there's a case difference
        if ($stored !== $lowercase) {
            $result = $generator->isValid($lowercase, 'test');
            $this->assertFalse($result);
        }
    }

    public function test_constructor_uses_provided_storage(): void
    {
        $customStorage = [];
        $generator = new CaptchaGenerator($customStorage);
        $generator->getCaptcha('test');

        $this->assertArrayHasKey('test', $customStorage[CaptchaGeneratorAbstract::STORAGE_KEY]);
        $this->assertEmpty($this->storage);
    }
}
