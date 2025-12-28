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
 * Font enumeration for CAPTCHA text rendering.
 *
 * Provides access to TrueType fonts bundled with the library. All fonts are
 * hand-picked from Google Fonts and are suitable for CAPTCHA generation.
 *
 * @since 1.0.0
 */
enum Font: string
{
    case ACME = 'Acme-Regular';
    case BANGERS = 'Bangers-Regular';
    case BARRIO = 'Barrio-Regular';
    case BREE_SERIF = 'BreeSerif-Regular';
    case FRECKLE_FACE = 'FreckleFace-Regular';
    case GOCHI_HAND = 'GochiHand-Regular';
    case LUCKIEST_GUY = 'LuckiestGuy-Regular';
    case PANGOLIN = 'Pangolin-Regular';
    case RALEWAY = 'Raleway-Regular';
    case RIGHTEOUS = 'Righteous-Regular';
    case ROBOTO_SLAB = 'RobotoSlab-Regular';
    case SANSITA = 'Sansita-Regular';

    /**
     * Returns all available font cases.
     *
     * @return array<Font> Array of all Font enum cases.
     */
    public static function all(): array
    {
        return self::cases();
    }

    /**
     * Returns a randomly selected font.
     *
     * Useful for generating CAPTCHAs with varied appearances to make them
     * harder for bots to recognize patterns.
     *
     * @return Font A randomly selected Font enum case.
     */
    public static function random(): Font
    {
        $fonts = self::all();

        return $fonts[random_int(0, count($fonts) - 1)];
    }

    /**
     * Returns the filesystem path to the font's TrueType file.
     *
     * @return string The absolute path to the .ttf font file.
     */
    public function getPath(): string
    {
        return sprintf('%s/../fonts/%s.ttf', __DIR__, $this->value);
    }
}
