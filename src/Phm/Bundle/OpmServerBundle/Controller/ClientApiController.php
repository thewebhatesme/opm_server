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
use MongoDate;
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
 * @RouteResource("Clientdata")
 *
 */
class ClientApiController extends FOSRestController
{

    /**
     * @var Crawler
     */
    private $domCrawler;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var MetricFactoryFactoryInterface
     */
    private $metricFactoryFactory;

    /**
     * Constructor
     */
    public function __construct(
      EntityManager $em,
      Crawler $domCrawler,
      MetricFactoryFactoryInterface $metricFactoryFactory
    )
    {
        $this->em = $em;
        $this->domCrawler = $domCrawler;
        $this->metricFactoryFactory = $metricFactoryFactory;
    }

    /**
     * @return View
     */
    public function postClientMeasurementsAction($clientUuid, $data)
    {
        $client = new Client();
        $measurement = new Measurement();
        $this->domCrawler->addXmlContent($data);

        $clientData = $this->domCrawler
          ->filter(Client::XMLNODENAME);

        $client->setClientId($clientUuid);
        $client->setDuration($clientData->filter(Client::XMLDURATIONNODENAME)->text());
        $client->setVersion($clientData->filter(Client::XMLVERSIONNODENAME)->text());
        $client->setLastactivity($clientData->filter(Client::XMLSTARTNODENAME)->text());


        $metricsToLoad = $this->domCrawler
          ->filter(Measurement::XMLNODENAME)
          ->filter(Measurement::METRICSXMLNODENAME);

        /** @var Crawler $metricToLoad */
        foreach ($metricsToLoad as $metricToLoad) {
            if ($this->metricFactoryFactory->hasMetricFactory($metricToLoad->attr['type'])) {
                $metricFactory = $this->metricFactoryFactory->createMetricFactory($metricToLoad->attr['type']);
                $metric = $metricFactory->createMetric($metricToLoad->attr['name']);

                $metric->setData(array($metricToLoad->children()));

                $measurement->addMetric($metric);
            } else {
                // @todo: Add some logging here.
                continue;
            }
        }

        // @todo: better errorhandling here...
        $this->em->getConnection()->beginTransaction();
        try {
            $this->em->persist($client);
            $this->em->persist($measurement);
            $this->em->flush();
            $this->em->getConnection()->commit();
        } catch (\Exception $e) {
            $this->em->getConnection()->rollback();
            throw $e;
        }

        $data = array();
        return $this->view($data, 200);
    }

    /**
     * @return View
     */
    public function getClientMeasurementAction($clientUuid)
    {
        $data = array();
        return $this->view($data, 200);
    }
}
