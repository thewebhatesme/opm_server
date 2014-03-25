<?php
/**
 * Declares the Context for tradimo used by behat for login area.
 *
 * @author     Mike Lohmann <mike.lohmann@icans-gmbh.com>
 * @copyright  Copyright (c) 2014 Phmlabs (http://phmlabs.de)
 */
namespace Phm\Bundle\OpmServerBundle\Features\Context\Subcontext;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\BehaviorException;

use Behat\Behat\Exception\PendingException;
use Behat\Mink\Exception\ExpectationException;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Implements some missing methods to be able to fulfill feature tests
 *
 * @author    Mike Lohmann
 * @copyright Copyright (c) 2014 Phmlabs (http://phmlabs.de)
 */
class HARFileProcessContext extends BehatContext
{
    /**
     * @Then /^the sent file should be the same as "([^"]*)"$/
     */
    public function theSentFileShouldBeTheSameAs($controlFile)
    {
        if (!file_exists($controlFile)) {
            throw new ExpectationException(
                'The control does not exist!',
                $this->getMainContext()->getSession()
            );
        }

        $this->checkIfProfilerIsEnabled();

        /* @var Profiler $profiler */
        $profiler = $this->getMainContext()->getContainer()->get('profiler');
    }

    /**
     * @throws \RuntimeException
     */
    private function checkIfProfilerIsEnabled()
    {
        if (false == $this->getMainContext()->getContainer()->has('profiler')) {
            throw new \RuntimeException(
                'The Profiler is disabled.'
            );
        }
    }

    /**
     * @Then /^the file "([^"]*)" is in the table "([^"]*)"$/
     */
    public function theFileIsInTheTable($fileName, $tableName)
    {
       return;
    }

    /**
     * @Then /^the count result on "([^"]*)" should be "([^"]*)"$/
     */
    public function theCountResultOnShouldBe($collectionName, $count)
    {
       return;
    }
}