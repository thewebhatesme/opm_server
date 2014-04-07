<?php
/**
 * Declares the AddMetricFactoriesPass class.
 *
 * @author     Mike Lohmann <mike.lohmann@phmlabs.de>
 */
namespace Phm\Bundle\OpmServerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class AddMetricFactoriesPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (false == $container->hasDefinition('phm.opmserver.metrics.metricfactoryfactory')) {
            return;
        }
        $definition = $container->getDefinition('phm.opmserver.metrics.metricfactoryfactory');

        foreach ($container->findTaggedServiceIds('opmserver.metricfactory') as $id => $attributes) {
            $definition->addMethodCall('addMetricFactory', array(new Reference($id)));
        }
    }
}