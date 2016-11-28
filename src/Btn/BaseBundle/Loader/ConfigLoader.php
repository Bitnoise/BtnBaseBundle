<?php

namespace Btn\BaseBundle\Loader;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ConfigLoader
{
    /** @var ContainerBuilder */
    private $container;
    /** @var YamlFileLoader */
    private $ymlFileLoader;

    /**
     * @param ContainerBuilder $container
     * @param YamlFileLoader   $ymlFileLoader
     */
    public function __construct(ContainerBuilder $container, YamlFileLoader $ymlFileLoader)
    {
        $this->container = $container;
        $this->ymlFileLoader = $ymlFileLoader;
    }

    /**
     * {@inheritdoc}
     */
    public function load($file, $type = null)
    {
        $ext = substr($file, strrpos($file, '.') + 1);

        if ('yml' !== $ext) {
            $file = $file .= '.yml';
        }

        $this->ymlFileLoader->load($file, $type);
    }

    /**
     * @param string      $file
     * @param string|null $type
     */
    public function tryLoad($file, $type = null)
    {
        try {
            return $this->load($file, $type);
        } catch (\InvalidArgumentException $e) {
            if (preg_match('~The file "[^"]+" does not exist~', $e->getMessage())) {
                // silently got through if file could not be loaded
                return;
            }
            throw $e;

        }
    }

    /**
     * @param array $fileArray
     * @param null  $type
     */
    public function tryLoadFromArray(array $fileArray, $type = null)
    {
        foreach ($fileArray as $file) {
            $this->tryLoad($file, $type);
        }
    }

    /**
     * @param      $extension
     * @param null $file
     * @param null $type
     */
    public function tryLoadForExtension($extension, $file = null, $type = null)
    {
        if ($this->container->hasExtension($extension)) {
            if (null === $file) {
                $file = $extension;
            }

            return $this->tryLoad($file, $type);
        }
    }
}
