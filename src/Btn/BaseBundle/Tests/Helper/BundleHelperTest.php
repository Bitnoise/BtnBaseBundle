<?php

namespace Btn\BaseBundle\Tests\Helper;

use Btn\BaseBundle\Helper\BundleHelper;
use Btn\BaseBundle\Controller\RedirectingController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BundleHelperTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Btn\BaseBundle\Helper\BundleHelper $helper */
    protected $helper;
    /** @var \Symfony\Bundle\FrameworkBundle\Controller\Controller $controller */
    protected $controller;
    /** @var \Symfony\Bundle\FrameworkBundle\Controller\Controller $controller */
    protected $redirectController;

    /**
     *
     */
    protected function setUp()
    {
        $this->helper             = new BundleHelper();
        $this->controller         = new Controller();
        $this->redirectController = new RedirectingController();
    }

    /**
     *
     */
    public function testGetReflectionClass()
    {
        $controllerRefClass       = $this->helper->getReflectionClass($this->controller);
        $cachedControllerRefClass = $this->helper->getReflectionClass($this->controller);
        $redControllerRefClass    = $this->helper->getReflectionClass($this->redirectController);

        $this->assertTrue($controllerRefClass instanceof \ReflectionClass);
        $this->assertTrue($redControllerRefClass instanceof \ReflectionClass);
        $this->assertNotEquals($controllerRefClass, $redControllerRefClass);
        $this->assertSame($controllerRefClass, $cachedControllerRefClass);
    }

    /**
     *
     */
    public function testGetClassName()
    {
        $controllerClassName    = $this->helper->getClassName($this->controller);
        $redControllerClassName = $this->helper->getClassName($this->redirectController);

        $this->assertEquals('Symfony\\Bundle\\FrameworkBundle\\Controller\\Controller', $controllerClassName);
        $this->assertEquals('Btn\\BaseBundle\\Controller\\RedirectingController', $redControllerClassName);
    }

    /**
     *
     */
    public function testGetBundleName()
    {
        $simpleBudleName         = $this->helper->getBundleName('Btn\\Some\\Dir\\SimpleBundle');
        $camelCaseBundleName     = $this->helper->getBundleName('Btn\\Some\\Dir\\CamelCaseBundle');
        $redControllerBundleName = $this->helper->getBundleName($this->redirectController);
        $controllerBundleName    = $this->helper->getBundleName($this->controller);

        $this->assertEquals('BtnSomeDirSimpleBundle', $simpleBudleName);
        $this->assertEquals('BtnSomeDirCamelCaseBundle', $camelCaseBundleName);
        $this->assertEquals('BtnBaseBundle', $redControllerBundleName);
        $this->assertEquals('FrameworkBundle', $controllerBundleName);
    }
}