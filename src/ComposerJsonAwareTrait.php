<?php

namespace Schnittstabil\ComposerExtra;

/**
 * Load composer.json.
 */
trait ComposerJsonAwareTrait
{
    /**
     * Load 'composer.json' and returns it as assoc array.
     *
     * @return array composer.json contents
     */
    protected function loadComposerJson()
    {
        return json_decode(file_get_contents('composer.json'));
    }
}
