<?php

namespace Schnittstabil\ComposerExtra\Presets;

class ThirdPreset
{
    public static function get()
    {
        $preset = new \stdClass();
        $preset->unicorns = 666;
        $preset->color = 'rainbow';
        $preset->thirdPreset = true;
        $preset->name = 'ThirdPreset';

        return $preset;
    }
}
