<?php

namespace Btn\BaseBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\Config\FileLocator;
use Btn\BaseBundle\Loader\ConfigLoader;

abstract class AbstractExtension extends Extension implements PrependExtensionInterface
{
    /** @var \ReflectionClass $reflectionClass $reflectionClass */
    protected $reflectionClass;

    /** @var array $resourceDir common bundle config directory */
    protected $resourceDir = '/../Resources/config';

    /** @var array $bundleConfigFiles common bundle config files to autoload */
    protected $bundleConfigFiles = array(
        'parameters',
        'services',
        'menus',
        'forms',
        'twig',
    );

    /** @var array $commonExtConfigFiles common extensions config files to autoload */
    protected $commonExtConfigFiles = array(
        'assetic',
    );

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // try to load bitnoise standard common bundle config files
        $loader = $this->getConfigLoader($container);
        $loader->tryLoadFromArray($this->bundleConfigFiles);
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        // try to load bitnoise standard common other extensions config files
        $loader = $this->getConfigLoader($container);
        $loader->tryLoadFromArray($this->commonExtConfigFiles);
        // try to load BtnNodeBundle content provider service definition file
        $loader->tryLoadForExtension('btn_node');
        $loader->tryLoadForExtension('btn_admin');
        $loader->tryLoadForExtension('btn_admin', 'btn_admin_forms');

        // $config = $this->getProcessedConfig($container, null, 'btn_base');
        // automatically register to assetic bundles
        // if ($container->hasExtension('assetic')) {
        //     $container->prependExtensionConfig('assetic', array(
        //         'bundles' => array($this->getBundleName()),
        //     ));
        // }
    }

    /**
     * @param ContainerBuilder $container
     * @param string|null      $rootDir
     * @param string|null      $resourceDir
     *
     * @return ConfigLoader
     */
    protected function getConfigLoader(ContainerBuilder $container, $rootDir = null, $resourceDir = null)
    {
        if (null === $rootDir) {
            $fileName = $this->getReflectionClass()->getFileName();
            $rootDir = substr($fileName, 0, strrpos($fileName, DIRECTORY_SEPARATOR));
        }

        if (null === $resourceDir) {
            $resourceDir = $this->resourceDir;
        }

        $yamlFileLoader = new YamlFileLoader($container,  new FileLocator($rootDir.$this->resourceDir));
        $loader = new ConfigLoader($container, $yamlFileLoader);

        return $loader;
    }

    /**
     * @todo  make alias parameter work
     */
    protected function getProcessedConfig(ContainerBuilder $container, array $configs = null, $alias = null)
    {
        if (null === $alias) {
            $alias = $this->getAlias();
        }

        if (null === $configs) {
            $configs = $container->getExtensionConfig($alias);
        }

        $fakeConfigArray = array();
        $configuration = $this->getConfiguration($fakeConfigArray, $container);
        $config = $this->processConfiguration($configuration, $configs);

        return $config;
    }

    /**
     *
     */
    protected function getBundleName()
    {
        return substr($this->getReflectionClass()->getShortName(), 0, -9).'Bundle';
    }

    /**
     *
     */
    protected function getReflectionClass()
    {
        if (!$this->reflectionClass) {
            $this->reflectionClass = new \ReflectionClass($this);
        }

        return $this->reflectionClass;
    }
}
