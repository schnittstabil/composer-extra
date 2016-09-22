# ComposerExtra [![Build Status](https://travis-ci.org/schnittstabil/composer-extra.svg?branch=master)](https://travis-ci.org/schnittstabil/composer-extra) [![Coverage Status](https://coveralls.io/repos/schnittstabil/composer-extra/badge.svg?branch=master&service=github)](https://coveralls.io/github/schnittstabil/composer-extra?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/schnittstabil/composer-extra/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/schnittstabil/composer-extra/?branch=master) [![Code Climate](https://codeclimate.com/github/schnittstabil/composer-extra/badges/gpa.svg)](https://codeclimate.com/github/schnittstabil/composer-extra)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/75b95f1a-f047-4ac3-ba89-1b424629df94/big.png)](https://insight.sensiolabs.com/projects/75b95f1a-f047-4ac3-ba89-1b424629df94)

> Get namespaced configuration from composer.json `extra`.


## Install

```sh
$ composer require schnittstabil/composer-extra
```


## Typical Usage

### End User

```json
{
    "name": "end-user/project",
    "require": {
        "you/your-awesome-library": "*"
    },
    "extra": {
        "you/your-awesome-library": {
            "unicorns": 42
        }
    },
}
```


### Your Library

```php
require __DIR__.'/vendor/autoload.php';

# get end-user configuration
$config = new Schnittstabil\ComposerExtra\ComposerExtra('you/your-awesome-library');
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
     * @see https://github.com/schnittstabil/get Documentation of `Schnittstabil\Get\getValue`.
     *
     * @param string|int|mixed[] $namespace     a `Schnittstabil\Get\getValue` path
     * @param mixed              $defaultConfig default configuration
     * @param string             $presetsPath   presets path (w/o namespace)
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct($namespace = array(), $defaultConfig = null, $presetsPath = null);

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
    public function get($path = array(), $default = null);

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
    public function getOrFail($path = array(), $message = null);
}
```


## License

MIT © [Michael Mayer](http://schnittstabil.de)
