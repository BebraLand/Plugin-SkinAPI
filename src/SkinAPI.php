<?php

namespace Azuriom\Plugin\SkinApi;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SkinAPI
{
    public const HIGH_RES_CAPE_MAX_WIDTH = 1024;

    public const HIGH_RES_CAPE_MAX_HEIGHT = 512;

    public static function getConstraints(bool $cape = false, bool $highResolutionCape = false): array
    {
        $prefix = $cape ? 'skin.capes.' : 'skin.';

        $width = (int) setting($prefix.'width', 64);
        $height = (int) setting($prefix.'height', 64);
        $scale = (int) setting($prefix.'scale', 1);

        if ($cape && $highResolutionCape) {
            return [
                'min_width' => $width,
                'min_height' => $height,
                'max_width' => static::HIGH_RES_CAPE_MAX_WIDTH,
                'max_height' => static::HIGH_RES_CAPE_MAX_HEIGHT,
            ];
        }

        if ($scale === 1) {
            return ['width' => $width, 'height' => $height];
        }

        return [
            'min_width' => $width,
            'min_height' => $height,
            'max_width' => $width * $scale,
            'max_height' => $height * $scale,
        ];
    }

    public static function getRule(bool $cape = false, bool $highResolutionCape = false): string
    {
        return Rule::dimensions(static::getConstraints($cape, $highResolutionCape));
    }

    /**
     * Get human-readable image dimensions accepted for an upload.
     */
    public static function dimensionsDescription(bool $cape = false, bool $highResolutionCape = false): string
    {
        $constraints = static::getConstraints($cape, $highResolutionCape);

        if (isset($constraints['width'])) {
            return "{$constraints['width']} x {$constraints['height']} px";
        }

        return "{$constraints['min_width']}-{$constraints['max_width']} x {$constraints['min_height']}-{$constraints['max_height']} px";
    }

    /**
     * Get validation messages that explain configured image requirements.
     */
    public static function validationMessages(bool $highResolutionCape = false): array
    {
        return [
            'skin.dimensions' => trans('skin-api::messages.invalid_image_dimensions', [
                'name' => trans('skin-api::messages.skin'),
                'dimensions' => static::dimensionsDescription(),
            ]),
            'cape.dimensions' => trans('skin-api::messages.invalid_image_dimensions', [
                'name' => trans('skin-api::messages.cape'),
                'dimensions' => static::dimensionsDescription(true, $highResolutionCape),
            ]),
        ];
    }

    public static function defaultSkin(): string
    {
        static::ensureDefaultSkin();

        return Storage::disk('public')->url('skins/default.png');
    }

    public static function ensureDefaultSkin(): void
    {
        if (! Storage::disk('public')->exists('skins/default.png')) {
            $defaultPath = plugin_path('skin-api/assets/img/steve.png');
            Storage::disk('public')->put('skins/default.png', file_get_contents($defaultPath));
        }
    }

    public static function defaultCape(): ?string
    {
        return Storage::disk('public')->exists('skins/capes/default.png')
            ? Storage::disk('public')->url('skins/capes/default.png')
            : null;
    }

    public static function hasDefaultCape(): bool
    {
        return setting('skin.capes.enable', false)
            && setting('skin.capes.default.enable', false)
            && static::defaultCape() !== null;
    }
}
