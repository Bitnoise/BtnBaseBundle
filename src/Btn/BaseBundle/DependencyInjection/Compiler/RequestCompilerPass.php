<?php

namespace Btn\BaseBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('request')) {
            return;
        }

        $requestDefinition = new Definition(RequestStack::class);
        $requestDefinition->setFactory([new Reference('request_stack'), 'getCurrentRequest']);

        $container->addDefinitions([
            'request' => $requestDefinition,
        ]);
    }
}
