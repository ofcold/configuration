<p align="center"><img src="https://raw.githubusercontent.com/ofcold/configuration/1.0/config.svg?sanitize=true"></p>

Larvel组件化配置项灵活覆盖
------------------------

<br>
    <p>
        <a href="https://github.com/ofcold/configuration/blob/1.0/README_zh_CN.md">Simplified Chinese Documentation</a>
    </p>
<br>


## 特色
 - 支持组件配置，配置文件可以在任何地方。
 - 覆盖配置，灵活。

## 安装

```bash
    composer require ofcold/configuration
```

## 说明
增强了laravel框架配置项目，支持覆盖。

## 使用

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