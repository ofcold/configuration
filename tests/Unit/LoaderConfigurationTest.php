<?php

use Ofcold\Configuration\LoaderConfiguration;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository;
use PHPUnit\Framework\TestCase;

class LoaderConfigurationTest extends TestCase
{
	protected $loaderFiles;

	protected $config;

	public function setUp()
	{
		$this->config = new Repository;

		$this->loaderFiles = new LoaderConfiguration(
			$this->config,
			new Filesystem
		);
	}

	public function testAddNamespace()
	{
		$this->loaderFiles->addNamespace('test', __DIR__ . '/../config');

		$this->assertEquals('example', $this->config->get('test::test.foo'));
	}

	public function testAddNamespaceOverrides()
	{
		$this->loaderFiles->addNamespace('test', __DIR__ . '/../config');
		$this->loaderFiles->addNamespaceOverrides('test', __DIR__ . '/../overrides');

		$this->assertEquals('overrides', $this->config->get('test::test.foo'));
	}
}