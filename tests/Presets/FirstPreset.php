<?php

namespace Schnittstabil\ComposerExtra\Presets;

class FirstPreset
{
    public static function get()
    {
        $preset = new \stdClass();
        $preset->unicorns = 666;
        $preset->color = '#000';
        $preset->firstPreset = true;
        $preset->name = 'FirstPreset';

        return $preset;
    }
}
