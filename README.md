# vaibhavpandeyvpz/ank
Simple and customizable captcha generation library, runs on [PHP](http://www.php.net/) >= 5.3.

> Ank: `अंक` (Number)

[![Build status][build-status-image]][build-status-url]
[![Code Coverage][code-coverage-image]][code-coverage-url]
[![Latest Version][latest-version-image]][latest-version-url]
[![Downloads][downloads-image]][downloads-url]
[![PHP Version][php-version-image]][php-version-url]
[![License][license-image]][license-url]

[![SensioLabsInsight][insights-image]][insights-url]

![Captcha](assets/captcha-anim.gif?raw=true "Captcha") ![Mathematics Captcha](assets/math-captcha-anim.gif?raw=true "Mathematics Captcha")

Install
-------
```bash
composer require vaibhavpandeyvpz/ank
```

Usage
-----
```php
<?php

/**
 * @desc Create an instance of desired captcha generator. Ank\CaptchaGenerator will generate a random captcha code
 *      while Ank\MathCaptchaGenerator will generate basic mathematics calculations for user to solve.
 */
$captcha = new Ank\CaptchaGenerator();
// or
$captcha = new Ank\MathCaptchaGenerator();

// Generate a captcha image and output the image to user-agent
header('Content-Type: image/png');
echo $captcha->getCaptcha();

// To verify user input at a later time
if ($captcha->isValid($_POST['captcha'])) {
    // ... captcha is valid
}

/*
 * @desc You can also customize look and feel of your image, change font, background or text color and lot more.
 */
$image = $captcha->getCaptcha()
    ->setBackgroundColor('#000')
    ->setForegroundColor('#efefef')
    ->setFont(Ank\CaptchaImage::FONT_ACME)
    ->setSize(256, 96)
    ->setQuality(100);

echo $image;
```

License
-------
See [LICENSE.md][license-url] file. Fonts hand-picked from [Google Fonts](https://fonts.google.com/).

[build-status-image]: https://img.shields.io/travis/vaibhavpandeyvpz/ank.svg?style=flat-square
[build-status-url]: https://travis-ci.org/vaibhavpandeyvpz/ank
[code-coverage-image]: https://img.shields.io/codecov/c/github/vaibhavpandeyvpz/ank.svg?style=flat-square
[code-coverage-url]: https://codecov.io/gh/vaibhavpandeyvpz/ank
[latest-version-image]: https://img.shields.io/github/release/vaibhavpandeyvpz/ank.svg?style=flat-square
[latest-version-url]: https://github.com/vaibhavpandeyvpz/ank/releases
[downloads-image]: https://img.shields.io/packagist/dt/vaibhavpandeyvpz/ank.svg?style=flat-square
[downloads-url]: https://packagist.org/packages/vaibhavpandeyvpz/ank
[php-version-image]: http://img.shields.io/badge/php-5.3+-8892be.svg?style=flat-square
[php-version-url]: https://packagist.org/packages/vaibhavpandeyvpz/ank
[license-image]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[license-url]: LICENSE.md
[insights-image]: https://insight.sensiolabs.com/projects/d97b6948-05e8-4edc-971c-1ce40e4a4115/small.png
[insights-url]: https://insight.sensiolabs.com/projects/d97b6948-05e8-4edc-971c-1ce40e4a4115
