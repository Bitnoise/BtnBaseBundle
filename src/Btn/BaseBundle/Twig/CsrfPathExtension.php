<?php

namespace Btn\BaseBundle\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 *
 */
class CsrfPathExtension extends \Twig_Extension
{
    /** @var \Symfony\Component\Routing\UrlGeneratorInterface */
    protected $router;
    /** @var \Symfony\Component\Security\Csrf\CsrfTokenManagerInterface */
    protected $csrfTokenManager;

    /**
     * @param UrlGeneratorInterface                           $router
     * @param CsrfProviderInterface|CsrfTokenManagerInterface $csrfTokenManager
     */
    public function __construct(UrlGeneratorInterface $router, CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->router           = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     *
     */
    public function getFunctions()
    {
        return array(
            'btn_csrf_path' => new \Twig_Function_Method($this, 'csrfPath'),
            'csrf_path'     => new \Twig_Function_Method($this, 'csrfPath'),
        );
    }

    /**
     *
     */
    public function csrfPath($name, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        if (empty($parameters['csrf_token'])) {
            $parameters['csrf_token'] = $this->csrfTokenManager->getToken($name)->getValue();
        }

        return $this->router->generate($name, $parameters, $referenceType);
    }

    /**
     *
     */
    public function getName()
    {
        return 'btn_base.extension.csrf_path';
    }
}
