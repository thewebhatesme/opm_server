<?php

namespace Phm\Bundle\OpmServerBundle;

use Phm\Bundle\OpmServerBundle\DependencyInjection\Compiler\AddMetricFactoriesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PhmOpmServerBundle extends Bundle
{
    /**
     * @{inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new AddMetricFactoriesPass($container));
    }
}
