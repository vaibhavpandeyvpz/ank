# Ank

[![Latest Version](https://img.shields.io/packagist/v/vaibhavpandeyvpz/ank.svg?style=flat-square)](https://packagist.org/packages/vaibhavpandeyvpz/ank)
[![Downloads](https://img.shields.io/packagist/dt/vaibhavpandeyvpz/ank.svg?style=flat-square)](https://packagist.org/packages/vaibhavpandeyvpz/ank)
[![PHP Version](https://img.shields.io/packagist/php-v/vaibhavpandeyvpz/ank.svg?style=flat-square)](https://packagist.org/packages/vaibhavpandeyvpz/ank)
[![License](https://img.shields.io/packagist/l/vaibhavpandeyvpz/ank.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/github/actions/workflow/status/vaibhavpandeyvpz/ank/tests.yml?branch=main&style=flat-square)](https://github.com/vaibhavpandeyvpz/ank/actions)

A simple, customizable, and modern CAPTCHA generation library for PHP 8.2+. Generate text-based or mathematics-based CAPTCHAs with full control over appearance, fonts, colors, and distortion.

> **Ank** (`अंक`) means "Number" in Hindi

![Text CAPTCHA](assets/captcha-anim.gif?raw=true "Text CAPTCHA") ![Math CAPTCHA](assets/math-captcha-anim.gif?raw=true "Math CAPTCHA")

## Features

- 🎨 **Two CAPTCHA Types**: Text-based alphanumeric codes or simple math problems
- 🎭 **Highly Customizable**: Colors, fonts, size, quality, and text distortion
- 🔒 **Secure**: Uses cryptographically secure random number generation
- 🎯 **One-Time Validation**: CAPTCHA answers are automatically removed after validation
- 🖼️ **12 Beautiful Fonts**: Hand-picked Google Fonts included
- 🚀 **Modern PHP**: Built with PHP 8.2+ features (enums, match expressions, strict types)
- 📦 **Zero Dependencies**: Only requires PHP with GD extension
- ✅ **Well Tested**: Comprehensive test suite with high code coverage

## Installation

Install via Composer:

```bash
composer require vaibhavpandeyvpz/ank
```

## Requirements

- PHP >= 8.2
- GD extension with FreeType support (for font rendering)

## Quick Start

### Basic Usage

```php
<?php

use Ank\CaptchaGenerator;
use Ank\MathCaptchaGenerator;

// Create a text-based CAPTCHA generator
$captcha = new CaptchaGenerator();

// Generate and display the CAPTCHA image
header('Content-Type: image/jpeg');
echo $captcha->getCaptcha();

// Later, validate user input
if ($captcha->isValid($_POST['captcha_code'])) {
    // CAPTCHA is valid
    echo "Verification successful!";
} else {
    // CAPTCHA is invalid
    echo "Invalid CAPTCHA code.";
}
```

### Mathematics CAPTCHA

```php
<?php

use Ank\MathCaptchaGenerator;

// Create a math-based CAPTCHA generator
$captcha = new MathCaptchaGenerator();

// Generate and display the math problem
header('Content-Type: image/jpeg');
echo $captcha->getCaptcha();

// Validate the answer (user provides numeric answer)
if ($captcha->isValid($_POST['answer'])) {
    echo "Correct answer!";
}
```

## Advanced Usage

### Customizing Appearance

The CAPTCHA image can be fully customized using a fluent interface:

```php
<?php

use Ank\CaptchaGenerator;
use Ank\Font;

$captcha = new CaptchaGenerator();

$image = $captcha->getCaptcha()
    ->setBackgroundColor('#000000')      // Black background
    ->setForegroundColor('#FFFFFF')      // White text
    ->setFont(Font::BANGERS)             // Use Bangers font
    ->setSize(300, 100)                  // 300x100 pixels
    ->setQuality(100)                     // Maximum JPEG quality
    ->setDistortion(15, 8);              // More distortion (angle, offset)

header('Content-Type: image/jpeg');
echo $image;
```

### Configuring Text CAPTCHA Length

```php
<?php

use Ank\CaptchaGenerator;

$captcha = new CaptchaGenerator();
$captcha->setLength(8);  // Generate 8-character codes

$image = $captcha->getCaptcha();
```

### Using Custom Storage

By default, CAPTCHA answers are stored in `$_SESSION`. You can provide a custom storage array:

```php
<?php

use Ank\CaptchaGenerator;

$customStorage = [];
$captcha = new CaptchaGenerator($customStorage);

// The CAPTCHA answer will be stored in $customStorage
$captcha->getCaptcha('my_captcha_id');
```

### Multiple CAPTCHAs

You can generate multiple CAPTCHAs with different IDs:

```php
<?php

use Ank\CaptchaGenerator;

$captcha = new CaptchaGenerator();

// Generate multiple CAPTCHAs
$image1 = $captcha->getCaptcha('login_form');
$image2 = $captcha->getCaptcha('registration_form');
$image3 = $captcha->getCaptcha('contact_form');

// Validate each independently
if ($captcha->isValid($_POST['login_captcha'], 'login_form')) {
    // Login form CAPTCHA is valid
}
```

### Available Fonts

The library includes 12 fonts from Google Fonts:

```php
use Ank\Font;

// All available fonts
Font::ACME
Font::BANGERS
Font::BARRIO
Font::BREE_SERIF
Font::FRECKLE_FACE
Font::GOCHI_HAND
Font::LUCKIEST_GUY
Font::PANGOLIN
Font::RALEWAY
Font::RIGHTEOUS
Font::ROBOTO_SLAB
Font::SANSITA

// Get a random font
$randomFont = Font::random();

// Get all fonts
$allFonts = Font::all();
```

### Color Formats

Colors can be specified in multiple formats:

```php
$image->setBackgroundColor('#FFFFFF');  // 6-digit hex with #
$image->setBackgroundColor('FFFFFF');   // 6-digit hex without #
$image->setBackgroundColor('#FFF');     // 3-digit hex with #
$image->setBackgroundColor('FFF');        // 3-digit hex without #
```

## API Reference

### CaptchaGenerator

Text-based CAPTCHA generator.

**Methods:**

- `getCaptcha(string $id = 'default'): CaptchaImageInterface` - Generate a new CAPTCHA
- `isValid(string $input, string $id = 'default'): bool` - Validate user input
- `setLength(int $length): static` - Set the length of generated codes

### MathCaptchaGenerator

Mathematics-based CAPTCHA generator.

**Methods:**

- `getCaptcha(string $id = 'default'): CaptchaImageInterface` - Generate a new math problem
- `isValid(string $input, string $id = 'default'): bool` - Validate the answer

### CaptchaImage

CAPTCHA image object with customization methods.

**Methods:**

- `getImage(): string` - Generate and return JPEG image data
- `setBackgroundColor(string $hex): static` - Set background color
- `setForegroundColor(string $hex): static` - Set text color
- `setFont(Font $font): static` - Set font
- `setSize(int $width, int $height): static` - Set image dimensions
- `setQuality(int $quality): static` - Set JPEG quality (0-100)
- `setDistortion(int $angle, int $offset): static` - Set text distortion
- `setText(string $text): static` - Set the text to display

## Error Handling

The library throws `Ank\Exception\ImageGenerationException` if image generation fails:

```php
<?php

use Ank\CaptchaGenerator;
use Ank\Exception\ImageGenerationException;

try {
    $captcha = new CaptchaGenerator();
    $image = $captcha->getCaptcha();
    echo $image->getImage();
} catch (ImageGenerationException $e) {
    // Handle image generation failure
    error_log('CAPTCHA generation failed: ' . $e->getMessage());
    // Fallback or error page
}
```

## Security Considerations

1. **One-Time Use**: CAPTCHA answers are automatically removed after validation to prevent replay attacks
2. **Secure Random**: Uses `random_int()` for cryptographically secure random number generation
3. **Session Storage**: By default uses PHP sessions, but you can provide custom storage
4. **Case Sensitive**: Text CAPTCHAs are case-sensitive by design

## Examples

### Complete Form Example

```php
<?php
// captcha.php - Generate CAPTCHA image
session_start();

use Ank\CaptchaGenerator;

$captcha = new CaptchaGenerator();
header('Content-Type: image/jpeg');
echo $captcha->getCaptcha('form_captcha');
```

```php
<?php
// form-handler.php - Validate form submission
session_start();

use Ank\CaptchaGenerator;

$captcha = new CaptchaGenerator();

if ($captcha->isValid($_POST['captcha'], 'form_captcha')) {
    // Process form
    echo "Form submitted successfully!";
} else {
    echo "Invalid CAPTCHA. Please try again.";
}
```

### AJAX Example

```php
<?php
// api/captcha.php
session_start();

use Ank\CaptchaGenerator;

$captcha = new CaptchaGenerator();
$image = $captcha->getCaptcha('ajax_captcha');

header('Content-Type: image/jpeg');
echo $image;
```

```javascript
// client-side
fetch("/api/captcha.php")
    .then((response) => response.blob())
    .then((blob) => {
        const img = document.getElementById("captcha-image");
        img.src = URL.createObjectURL(blob);
    });
```

## Testing

Run the test suite:

```bash
composer test
```

Or with PHPUnit directly:

```bash
vendor/bin/phpunit
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

Fonts are hand-picked from [Google Fonts](https://fonts.google.com/) and are used in accordance with their licenses.

## Author

**Vaibhav Pandey**

- GitHub: [@vaibhavpandeyvpz](https://github.com/vaibhavpandeyvpz)
- Email: contact@vaibhavpandey.com

## Changelog

See [GitHub Releases](https://github.com/vaibhavpandeyvpz/ank/releases) for the changelog.
