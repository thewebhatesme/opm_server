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
        if (!$container->hasDefinition('opmserver.metricfactory')) {
            return;
        }

        $factories = array();
        foreach ($container->findTaggedServiceIds('opmserver.metricfactory') as $id => $attributes) {
            $factories[] = new Reference($id);
        }

        $container
          ->getDefinition('phm.opmserver.metrics.metricfactoryfactory')
          ->replaceArgument(0, $factories);
    }
}