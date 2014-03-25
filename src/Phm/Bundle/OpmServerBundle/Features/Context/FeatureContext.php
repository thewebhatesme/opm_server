<?php
/**
 * Declares the FeatureContext
 *
 * @author    Mike Lohmann
 * @copyright 2014 Phmlabs
 */
namespace Phm\Bundle\OpmServerBundle\Features\Context;

use Behat\Behat\Context\Step as Steps;
use Behat\Behat\Event\FeatureEvent;
use Behat\Behat\Event\ScenarioEvent;
use Behat\Behat\Event\SuiteEvent;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\Symfony2Extension\Driver\KernelDriver;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Phm\Bundle\OpmServerBundle\Features\Context\Subcontext\HARFileProcessContext;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Implements some missing methods to be able to fulfill feature tests
 *
 * @author    Mike Lohmann
 * @copyright Copyright (c) 2014 Phmlabs (http://phmlabs.de)
 */
class FeatureContext extends MinkContext
{
    /**
     * @const string
     */
    const DROP_COLLECTION_TAG = 'DropCollection';

    // trait to have kernel + container available
    use KernelDictionary;

    /**
     * Introducing subcontextes
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->useContext('file_process', new HARFileProcessContext($parameters));
    }

    /**
     * @BeforeScenario @DropTables
     */
    static public function dropTables(ScenarioEvent $event)
    {
        /* @var FeatureContext $context */
        $context = $event->getContext();

        $context->printDebug('Droping Collections');

        /* @var Container $container */
        $container = $context->getContainer();
    }
}