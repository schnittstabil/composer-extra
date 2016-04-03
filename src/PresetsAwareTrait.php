<?php

namespace Schnittstabil\ComposerExtra;

/**
 * Load additional presets.
 */
trait PresetsAwareTrait
{
    /**
     * Load single preset.
     *
     * @param mixed $preset preset to load
     *
     * @return array configuration of preset
     */
    protected function loadPreset($preset)
    {
        return call_user_func($preset);
    }

    /**
     * Load presets.
     *
     * @param mixed $presets presets to load
     *
     * @return array preset configurations
     */
    protected function loadPresets($presets)
    {
        if (empty($presets)) {
            return [];
        }

        return array_map([$this, 'loadPreset'], $presets);
    }
}
