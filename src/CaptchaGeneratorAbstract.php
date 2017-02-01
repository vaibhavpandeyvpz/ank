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
    /**
     * @var array
     */
    protected $captchas;

    /**
     * CaptchaGeneratorAbstract constructor.
     * @param array $storage
     */
    public function __construct(array &$storage = null)
    {
        if (is_null($storage)) {
            $storage = &$_SESSION;
        }
        if (empty($storage['captchas'])) {
            $storage['captchas'] = array();
        }
        $this->captchas = &$storage['captchas'];
    }

    /**
     * {@inheritdoc}
     */
    public function isValid($input, $id = 'default')
    {
        if (isset($this->captchas[$id])) {
            $result = $input == $this->captchas[$id];
            unset($this->captchas[$id]);
            return $result;
        }
        return false;
    }
}
