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
 * Class CaptchaGeneratorAbstract
 * @package Ank
 */
abstract class CaptchaGeneratorAbstract implements CaptchaGeneratorInterface
{
    const STORAGE_KEY = __NAMESPACE__;

    /**
     * @var array
     */
    protected $storage;

    /**
     * CaptchaGeneratorAbstract constructor.
     * @param array $storage
     */
    public function __construct(array &$storage = null)
    {
        if (is_null($storage)) {
            $storage = &$_SESSION;
        }
        if (empty($storage[self::STORAGE_KEY])) {
            $storage[self::STORAGE_KEY] = array();
        }
        $this->storage = &$storage[self::STORAGE_KEY];
    }

    /**
     * {@inheritdoc}
     */
    public function isValid($input, $id = 'default')
    {
        if (isset($this->storage[$id])) {
            $result = $input == $this->storage[$id];
            unset($this->storage[$id]);
            return $result;
        }
        return false;
    }
}
