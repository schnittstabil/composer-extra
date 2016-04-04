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

### Schnittstabil\ComposerExtra\ComposerExtra->get($path = array(), $default = null)

Returns a configuration value.

#### $path
Type: `string|int|mixed[]`

See <a href="https://github.com/schnittstabil/get" target="_blank">`getValue`</a>  for details.

#### $default

Default value if `$path` is not valid.


### Schnittstabil\ComposerExtra\ComposerExtra->getOrFail($path = array(), $message = null)

Returns a configuration value. Throws `\OutOfBoundsException` if `$path` is not valid.

#### $path
Type: `string|int|mixed[]`

See <a href="https://github.com/schnittstabil/get" target="_blank">`getValueOrFail`</a>  for details.


#### $message

Exception message.


## License

MIT © [Michael Mayer](http://schnittstabil.de)
