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
 * Abstract base class for CAPTCHA generators.
 *
 * Provides common functionality for storing and validating CAPTCHA answers.
 * Handles storage management using either the provided array reference or
 * PHP's $_SESSION superglobal.
 *
 * @since 1.0.0
 */
abstract class CaptchaGeneratorAbstract implements CaptchaGeneratorInterface
{
    /**
     * Storage key used to namespace CAPTCHA data in the storage array.
     *
     * @var string
     */
    public const STORAGE_KEY = __NAMESPACE__;

    /**
     * Storage array for CAPTCHA answers.
     *
     * Keys are CAPTCHA IDs, values are the answers (strings for text CAPTCHAs,
     * integers for math CAPTCHAs).
     *
     * @var array<string, string|int>
     */
    protected array $storage;

    /**
     * Constructor.
     *
     * Initializes the storage mechanism. If no storage array is provided,
     * uses PHP's $_SESSION superglobal. The storage is passed by reference
     * to allow modifications.
     *
     * @param  array<string, mixed>|null  $storage  Optional storage array passed by reference.
     *                                              If null, uses $_SESSION. The array will
     *                                              be modified to include the storage key
     *                                              if it doesn't exist.
     */
    public function __construct(?array &$storage = null)
    {
        if ($storage === null) {
            $storage = &$_SESSION;
        }
        if (! isset($storage[self::STORAGE_KEY]) || ! is_array($storage[self::STORAGE_KEY])) {
            $storage[self::STORAGE_KEY] = [];
        }
        $this->storage = &$storage[self::STORAGE_KEY];
    }

    /**
     * {@inheritdoc}
     *
     * Validates the input and removes the stored value after validation
     * (one-time use) to prevent replay attacks.
     */
    public function isValid(string $input, string $id = 'default'): bool
    {
        if (! isset($this->storage[$id])) {
            return false;
        }

        $result = $input === (string) $this->storage[$id];
        unset($this->storage[$id]);

        return $result;
    }
}
