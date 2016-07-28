<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\CartBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
final class RegisterCartContextsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('sylius.registry.cart_context')) {
            return;
        }

        $registry = $container->findDefinition('sylius.registry.cart_context');

        foreach ($container->findTaggedServiceIds('sylius.cart_context') as $id => $attributes) {
            $priority = isset($attributes[0]['priority']) ? (int) $attributes[0]['priority'] : 0;

            $registry->addMethodCall('register', [new Reference($id), $priority]);
        }
    }
}
