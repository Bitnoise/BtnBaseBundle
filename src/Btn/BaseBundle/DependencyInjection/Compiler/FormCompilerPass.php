<?php

namespace Btn\BaseBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FormCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('btn_base.form.registry')) {
            return;
        }

        $formRegistry = $container->getDefinition('btn_base.form.registry');
        $forms = $container->findTaggedServiceIds('form.type');

        foreach ($forms as $id => $tags) {
            foreach ($tags as $attributes) {
                if (!array_key_exists('alias', $attributes)) {
                    continue;
                }

                if (empty($attributes['alias'])) {
                    continue;
                }

                $definition = $container->getDefinition($id);

                $formRegistry->addMethodCall('addType', array($attributes['alias'], $definition->getClass()));
            }
        }
    }
}
