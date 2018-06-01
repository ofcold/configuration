<?php

namespace Ofcold\Configuration;

use SplFileInfo;

/**
 * Class LoaderConfiguration
 *
 * @link   https://ofcold.com
 * @link   https://ofcold.com/license
 *
 * @author Ofcold <support@ofcold.com>
 * @author Olivia Fu <olivia@ofcold.com>
 * @author Bill Li <bill.li@ofcold.com>
 *
 * @package	Ofcold\Configuration\LoaderConfiguration
 */
class LoaderConfiguration
{
	/**
	 * The configure instance.
	 *
	 * @var \Ofcold\Configure\Repository
	 */
	protected $configure;

	/**
	 * The Filsystem instance.
	 *
	 * @var \Ofcold\Filesystem\Filesystem
	 */
	protected $filesystem;

	/**
	 * Create a configure ArrayLoader instance.
	 *
	 *  @param Repository $configure
	 *  @param Filesystem $filesystem
	 */
	public function __construct(Repository $configure, Filesystem $filesystem)
	{
		 $this->configure = $configure;

		 $this->filesystem = $filesystem;
	}

	/**
	 * Add a namespace to configure.
	 *
	 * @param string $namespace
	 * @param string $directory
	 *
	 * @return void
	 */
	public function addNamespace(?string $namespace = null, string $directory) : void
	{
		if ( ! $this->filesystem->isDirectory($directory) ) {
			return;
		}

		foreach ( $this->filesystem->allFiles($directory) as $file ) {
			$key = $this->getKeyFromFile($directory, $file);

			//	Get the namespace key.
			$stream = $namespace ? $namespace . '::' . $key : null;

			$this->configure->set($stream, $this->filesystem->getRequire($file->getPathname()));
		}
	}

	/**
	 * Add namespace overrides to configuration.
	 *
	 * @param $namespace
	 * @param $directory
	 */
	public function addNamespaceOverrides($namespace, $directory) : void
	{
		if (!$this->files->isDirectory($directory)) {
			return;
		}

		/* @var SplFileInfo $file */
		foreach ($this->filesystem->allFiles($directory) as $file) {

			$key = $this->getKeyFromFile($directory, $file);

			$this->configure->set(
				"{$namespace}::{$key}",
				array_replace(
					$this->configure->get("{$namespace}::{$key}", []),
					$this->filesystem->getRequire($file->getPathname())
				)
			);
		}
	}

	/**
	 * Parse a key from the file
	 *
	 * @param string      $directory
	 * @param SplFileInfo $file
	 *
	 * @return string
	 */
	private function getKeyFromFile(string $directory, SplFileInfo $file) : string
	{
		// Normalize slashes so that the key reader knows how to work with them.
		return str_replace(
			DIRECTORY_SEPARATOR,
			'/',
			trim(
				str_replace(
					str_replace('\\', DIRECTORY_SEPARATOR, $directory),
					'',
					$file->getPath()
				) . DIRECTORY_SEPARATOR . $file->getBaseName('.php'),
				DIRECTORY_SEPARATOR
			)
		);
	}

}