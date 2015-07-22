<?php

namespace Btn\BaseBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Btn\BaseBundle\Helper\BundleHelper;

class BundleExtension extends \Twig_Extension
{
    /** @var BundleHelper */
    private $bundleHelper;

    /**
     * @param BundleHelper $bundleHelper
     */
    public function __construct(BundleHelper $bundleHelper)
    {
        $this->bundleHelper = $bundleHelper;
    }

    /**
     *
     */
    public function getFunctions()
    {
        return array(
            'btn_bundle_is_enabled' => new \Twig_Function_Method($this, 'isEnabled'),
        );
    }

    /**
     *
     */
    public function isEnabled($bundle)
    {
        return $this->bundleHelper->isEnabled($bundle);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_base.extension.bundle';
    }
}
