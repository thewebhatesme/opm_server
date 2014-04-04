<?php
/**
 * @author     Mike Lohmann <mike.h.lohmann@gmail.com>
 *
 * ClientApiController
 */
namespace Phm\Bundle\OpmServerBundle\Controller;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;

use Phm\Component\Metrics\MetricInterface;
use Phm\Component\Storage\StorageStrategyInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\DomCrawler\Crawler;

use Phm\Bundle\OpmServerBundle\Entity\Measurement;
use Phm\Bundle\OpmServerBundle\Entity\Client;
use Phm\Component\Metrics\MetricFactoryFactoryInterface;
/**
 * Class ClientApiController
 * @Route(service="phm.opmserver.controller.clientapi")
 * RouteResource("Clientdata")
 *
 */
class ClientApiController extends FOSRestController
{

    /**
     * @var Crawler
     */
    private $domCrawler;

    /**
     * @var StorageStrategyInterface
     */
    private $storageStrategy;

    /**
     * @var MetricFactoryFactoryInterface
     */
    private $metricFactoryFactory;

    /**
     * Constructor
     */
    public function __construct(
      StorageStrategyInterface $storageStrategy,
      MetricFactoryFactoryInterface $metricFactoryFactory
    )
    {
        $this->storageStrategy = $storageStrategy;
        $this->metricFactoryFactory = $metricFactoryFactory;
        $this->domCrawler = new Crawler();
    }

    /**
     * @Post("/clients/{clientUuid}/measurement", name="post_userdatas_file",
     *      requirements={"clientUuid" = "\d+"})
     *
     * @return View
     */
    public function postClientMeasurementAction($clientUuid, Request $request)
    {
        $data = $request->getContent();

        $client = $this->storageStrategy->createClientItem();
        $measurement = $this->storageStrategy->createMeasurementItem();

        $this->domCrawler->addXmlContent($data);

        $clientData = $this->domCrawler
          ->filterXpath('//testresult/' . Client::XMLNODENAME);

        $client->setClientId($clientUuid);
        $client->setDuration($clientData->filterXpath('//' . Client::XMLDURATIONNODENAME)->text());
        $client->setVersion($clientData->filterXpath('//' .Client::XMLVERSIONNODENAME)->text());
        $client->setLastactivity(new \DateTime($clientData->filterXpath('//' .Client::XMLSTARTNODENAME)->text()));

        $metricsToLoad = $this->domCrawler
          ->filterXpath('//testresult/' . Measurement::XMLNODENAME . '/' . Measurement::METRICSXMLNODENAME);

        /** @var \DomElement $metricToLoad */
        foreach ($metricsToLoad->children() as $metricToLoad) {
            $factoryType = $metricToLoad->attributes->getNamedItem(MetricInterface::TYPEXMLNODEATTRIBUTE)->nodeValue;
            $metricName = $metricToLoad->attributes->getNamedItem(MetricInterface::NAMEXMLNODEATTRIBUTE)->nodeValue;
            if ($this->metricFactoryFactory->hasMetricFactory($factoryType)) {
                $metricFactory = $this->metricFactoryFactory->createMetricFactory($factoryType);
                $metric = $metricFactory->createMetric($metricName);
                $metric->setData($metricToLoad->children());
                $measurement->addMetric($metric);
            } else {
                // @todo: Add some logging here.
                continue;
            }
        }
        return $this->view(null, 400);
    }

    /**
     * @return View
     */
    public function getClientMeasurementsAction($clientUuid)
    {
        $data = array('Ok');
        return $this->view($data, 200);
    }
}
