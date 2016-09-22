<?php

namespace Schnittstabil\ComposerExtra;

use function Schnittstabil\Get\getValue;
use function Schnittstabil\Get\getValueOrFail;
use Schnittstabil\Get\Get;

/**
 * Get namespaced configuration from `composer.json`.
 */
class ComposerExtra
{
    use PresetsAwareTrait;
    use ComposerJsonAwareTrait;

    protected $config;
    protected $namespace;
    protected $defaultConfig;
    protected $presetsPath;

    /**
     * Merge configurations.
     *
     * @var callable
     */
    public $merge = '\Schnittstabil\ConfigMerge\config_merge';

    /**
     * Create a new ComposerExtra.
     *
     * @see https://github.com/schnittstabil/get Documentation of `Schnittstabil\Get\getValue`
     *
     * @param string|int|mixed[] $namespace     a `Schnittstabil\Get\getValue` path
     * @param mixed              $defaultConfig default configuration
     * @param string             $presetsPath   presets path (w/o namespace)
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct($namespace = array(), $defaultConfig = null, $presetsPath = null)
    {
        $this->namespace = Get::normalizePath($namespace);
        array_unshift($this->namespace, 'extra');
        $this->defaultConfig = $defaultConfig === null ? new \stdClass() : $defaultConfig;
        $this->presetsPath = $presetsPath;
    }

    /**
     * Merge two configs.
     *
     * @param mixed $target Target config
     * @param mixed $source Source config
     *
     * @return mixed The merged config
     */
    protected function merge($target, $source)
    {
        if ($source === null) {
            return $target;
        }

        return call_user_func($this->merge, $target, $source);
    }

    /**
     * Get the configuration.
     *
     * @return mixed the configuration
     */
    protected function getConfig()
    {
        if ($this->config !== null) {
            return $this->config;
        }

        $config = $this->merge(
            $this->defaultConfig,
            getValue($this->namespace, $this->loadComposerJson())
        );

        if ($this->presetsPath === null || $config === null) {
            return $this->config = $config;
        }

        $presets = $this->loadPresets(getValue($this->presetsPath, $config, []));
        $presetsConfig = array_reduce($presets, $this->merge, array_shift($presets));

        return $this->config = $this->merge($presetsConfig, $config);
    }

    /**
     * Get configuration value.
     *
     * @see https://github.com/schnittstabil/get Documentation of `Schnittstabil\Get\getValue`
     *
     * @param string|int|mixed[] $path    a `Schnittstabil\Get\getValue` path
     * @param mixed              $default default value if $path is not valid
     *
     * @return mixed the value determined by `$path` or otherwise `$default`
     */
    public function get($path = array(), $default = null)
    {
        return getValue($path, $this->getConfig(), $default);
    }

    /**
     * Get configuration value.
     *
     * @see https://github.com/schnittstabil/get Documentation of `Schnittstabil\Get\getValueOrFail`
     *
     * @param string|int|mixed[] $path    a `Schnittstabil\Get\getValueOrFail` path
     * @param mixed              $message exception message
     *
     * @throws \OutOfBoundsException if `$path` is not valid
     *
     * @return mixed the value determined by `$path`
     */
    public function getOrFail($path = array(), $message = null)
    {
        return getValueOrFail($path, $this->getConfig(), $message);
    }
}
