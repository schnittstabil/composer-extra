<?php

namespace Schnittstabil\ComposerExtra\Presets;

class SecondPreset
{
    public static function get()
    {
        $preset = new \stdClass();
        $preset->unicorns = 666;
        $preset->color = 'rainbow';
        $preset->secondPreset = true;
        $preset->name = 'SecondPreset';

        return $preset;
    }
}
