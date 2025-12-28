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
 * Class FontTest
 */
class FontTest extends TestCase
{
    public function test_all_returns_array_of_fonts(): void
    {
        $fonts = Font::all();

        $this->assertIsArray($fonts);
        $this->assertNotEmpty($fonts);
        foreach ($fonts as $font) {
            $this->assertInstanceOf(Font::class, $font);
        }
    }

    public function test_all_returns_all_font_cases(): void
    {
        $fonts = Font::all();

        $expectedFonts = [
            Font::ACME,
            Font::BANGERS,
            Font::BARRIO,
            Font::BREE_SERIF,
            Font::FRECKLE_FACE,
            Font::GOCHI_HAND,
            Font::LUCKIEST_GUY,
            Font::PANGOLIN,
            Font::RALEWAY,
            Font::RIGHTEOUS,
            Font::ROBOTO_SLAB,
            Font::SANSITA,
        ];

        $this->assertCount(count($expectedFonts), $fonts);
        foreach ($expectedFonts as $expectedFont) {
            $this->assertContains($expectedFont, $fonts);
        }
    }

    public function test_random_returns_font(): void
    {
        $font = Font::random();

        $this->assertInstanceOf(Font::class, $font);
    }

    public function test_random_returns_different_fonts(): void
    {
        $fonts = [];
        for ($i = 0; $i < 50; $i++) {
            $fonts[] = Font::random();
        }

        // Convert to values for comparison
        $fontValues = array_map(fn (Font $font) => $font->value, $fonts);
        $unique = array_unique($fontValues);
        $this->assertGreaterThan(1, count($unique), 'Random should return different fonts');
    }

    public function test_get_path_returns_valid_path(): void
    {
        $font = Font::ACME;
        $path = $font->getPath();

        $this->assertIsString($path);
        $this->assertStringEndsWith('.ttf', $path);
        $this->assertStringContainsString('fonts', $path);
    }

    public function test_get_path_returns_existing_file(): void
    {
        $font = Font::ACME;
        $path = $font->getPath();

        $this->assertFileExists($path, "Font file should exist: {$path}");
    }

    public function test_all_fonts_have_valid_paths(): void
    {
        $fonts = Font::all();

        foreach ($fonts as $font) {
            $path = $font->getPath();
            $this->assertFileExists($path, "Font file should exist for {$font->value}: {$path}");
        }
    }

    public function test_font_values_are_strings(): void
    {
        $fonts = Font::all();

        foreach ($fonts as $font) {
            $this->assertIsString($font->value);
            $this->assertNotEmpty($font->value);
        }
    }

    public function test_font_enum_cases(): void
    {
        $this->assertEquals('Acme-Regular', Font::ACME->value);
        $this->assertEquals('Bangers-Regular', Font::BANGERS->value);
        $this->assertEquals('Barrio-Regular', Font::BARRIO->value);
        $this->assertEquals('BreeSerif-Regular', Font::BREE_SERIF->value);
        $this->assertEquals('FreckleFace-Regular', Font::FRECKLE_FACE->value);
        $this->assertEquals('GochiHand-Regular', Font::GOCHI_HAND->value);
        $this->assertEquals('LuckiestGuy-Regular', Font::LUCKIEST_GUY->value);
        $this->assertEquals('Pangolin-Regular', Font::PANGOLIN->value);
        $this->assertEquals('Raleway-Regular', Font::RALEWAY->value);
        $this->assertEquals('Righteous-Regular', Font::RIGHTEOUS->value);
        $this->assertEquals('RobotoSlab-Regular', Font::ROBOTO_SLAB->value);
        $this->assertEquals('Sansita-Regular', Font::SANSITA->value);
    }
}
