<?php

namespace Btn\BaseBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class TranslationExtension extends \Twig_Extension
{
    /** @var ContainerInterface */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('btn_translation', [$this, 'translation']),
        );
    }

    /**
     * @param string|array $input
     * @param string|null  $locale
     *
     * @return string|null
     */
    public function translation($input, $locale = null)
    {
        if (is_string($input)) {
            return $input;
        }

        if (null === $locale) {
            $locale = $this->container->get('request_stack')->getCurrentRequest()->getLocale();
        }

        return isset($input[$locale]) ? $input[$locale] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_base.extension.translation';
    }
}
