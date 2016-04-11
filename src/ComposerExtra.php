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
     * @see https://github.com/schnittstabil/get Documentation of `Schnittstabil\Get\getValue`.
     *
     * @param string|int|mixed[] $namespace     a `Schnittstabil\Get\getValue` path
     * @param array              $defaultConfig default configuration
     * @param string             $presetsPath   presets path (w/o namespace)
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct($namespace = array(), array $defaultConfig = null, $presetsPath = null)
    {
        $this->namespace = Get::normalizePath($namespace);
        array_unshift($this->namespace, 'extra');
        $this->defaultConfig = $defaultConfig === null ? array() : $defaultConfig;
        $this->presetsPath = $presetsPath;
    }

    /**
     * Get the configuration.
     *
     * @return array the configuration
     */
    protected function getConfig()
    {
        if ($this->config !== null) {
            return $this->config;
        }

        $composerConfig = getValue($this->namespace, $this->loadComposerJson(), []);
        $config = call_user_func($this->merge, $this->defaultConfig, $composerConfig);

        if ($this->presetsPath !== null) {
            $presets = $this->loadPresets(getValue($this->presetsPath, $config, []));
            $configs = array_reduce($presets, $this->merge, []);
            $config = call_user_func($this->merge, $configs, $config);
        }

        return $this->config = $config;
    }

    /**
     * Get configuration value.
     *
     * @see https://github.com/schnittstabil/get Documentation of `Schnittstabil\Get\getValue`.
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
     * @see https://github.com/schnittstabil/get Documentation of `Schnittstabil\Get\getValueOrFail`.
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
