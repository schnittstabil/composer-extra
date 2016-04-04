# ComposerExtra [![Build Status](https://travis-ci.org/schnittstabil/composer-extra.svg?branch=master)](https://travis-ci.org/schnittstabil/composer-extra) [![Coverage Status](https://coveralls.io/repos/schnittstabil/composer-extra/badge.svg?branch=master&service=github)](https://coveralls.io/github/schnittstabil/composer-extra?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/schnittstabil/composer-extra/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/schnittstabil/composer-extra/?branch=master) [![Code Climate](https://codeclimate.com/github/schnittstabil/composer-extra/badges/gpa.svg)](https://codeclimate.com/github/schnittstabil/composer-extra)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/75b95f1a-f047-4ac3-ba89-1b424629df94/big.png)](https://insight.sensiolabs.com/projects/75b95f1a-f047-4ac3-ba89-1b424629df94)

> Get namespaced configuration from composer.json `extra`.


## Install

```
$ composer require schnittstabil/composer-extra
```


## Usage

```json
{
    "name": "some-vendor/some-project",
    "extra": {
        "vendor/project": {
            "unicorns": 42
        }
    },
}
```

```php
require __DIR__.'/vendor/autoload.php';

$config = new Schnittstabil\ComposerExtra\ComposerExtra('vendor/project');
$config->get('unicorns') //=> int(42)
```


## API

```php
namespace Schnittstabil\ComposerExtra;

/**
 * Get namespaced configuration from `composer.json`.
 */
class ComposerExtra
{
    /**
     * Create a new ComposerExtra.
     *
     * @param string|int|mixed[] $namespace     See `Schnittstabil\Get\getValue` for details
     * @param array              $defaultConfig default configuration
     * @param string             $presetsPath   presets path (w/o namespace)
     */
    public function __construct($namespace = array(), array $defaultConfig = null, $presetsPath = null);

    /**
     * Get configuration value.
     *
     * @param string|int|mixed[] $path    See `Schnittstabil\Get\getValue` for details
     * @param mixed              $default default value if $path is not valid
     *
     * @return mixed the value determined by `$path` or otherwise `$default`
     */
    public function get($path = array(), $default = null);

    /**
     * Get configuration value.
     *
     * @param string|int|mixed[] $path    See `Schnittstabil\Get\getValueOrFail` for details
     * @param mixed              $message exception message
     *
     * @throws \OutOfBoundsException if `$path` is not valid
     *
     * @return mixed the value determined by `$path`
     */
    public function getOrFail($path = array(), $message = null);
}

```


## License

MIT © [Michael Mayer](http://schnittstabil.de)
