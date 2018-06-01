<p align="center"><img src="https://raw.githubusercontent.com/ofcold/configuration/1.0/config.svg?sanitize=true"></p>

Configuration item supports laravel extension.
------------------------

<br>
    <p>
        <a href="https://github.com/ofcold/configuration/blob/1.0/README_zh_CN.md">Simplified Chinese Documentation</a>
    </p>
<br>

## Features
 - Support component configuration, configuration files can be anywhere.
 - Overlay configuration, flexible.

## Environment
php >= 7.1

## Installing

```bash
    composer require ofcold/configuration
```

## Instructions
We may use such a scenario, in the development of Laravel components, need some configuration, or multiple configuration items. The original Laravel may require you to merge configurations and publish to the root directory.
As the number of components increases, so does the config file.

## Useing

```php

use Ofcold\Configuration\LoaderConfiguration;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository;

$loader = new LoaderConfiguration(
	$config = new Repository,
	new Filesystem
);

$loader->addNamespace('test', __DIR__ . '/tests/config');

print_r(json_encode($config->all()));
// print_r($config->get('test::test.foo') . "\r\n");

$loader->addNamespaceOverrides('test', __DIR__ . '/tests/overrides');

print_r(json_encode($config->all()));
// print_r($config->get('test::test.foo')  . "\r\n");

```

#### Results:
```json
{
	"test::test":{
		"foo":"example"
	}
}

{
	"test::test":{
		"foo":"overrides"
	}
}
```


Larvel
```php

use Ofcold\Configuration\LoaderConfiguration;

class Foo
{
	/**
	 * Create an a new Foo instance.
	 *
	 * @param LoaderConfiguration $loader
	 */
	public function __construct(LoaderConfiguration $loader)
	{
		$loader->addNamespace('test', '/config');
	}
}
```

#### OR test file.
```bash
    php test
```

### Api
 - addNamespace(?string $namespace = null, string $directory) : void
 - addNamespaceOverrides($namespace, $directory) : void