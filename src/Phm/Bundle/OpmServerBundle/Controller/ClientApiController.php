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
      HttpMetricFactoryFactoryInterface $metricFactoryFactory
    )
    {
        $this->em = $em;
        $this->domCrawler = $domCrawler;
        $this->metricFactoryFactory = $metricFactoryFactory;
    }

    /**
     * @return View
     */
    public function postClientdataAction($clientUuid, $data)
    {
        $data = array();

        $client = new Client();
        $measurement = new Measurement();


        $this->domCrawler->addXmlContent($data);

        $clientData = $this->domCrawler
          ->filter(Client::XMLNODENAME);

        $client->setClientId();
        $client->setDuration();
        $client->setVersion();
        $client->setLastactivity();


        $metricsToLoad = $this->domCrawler
          ->filter(Measurement::XMLNODENAME)
          ->filter(Measurement::METRICSXMLNODENAME);

        /** @var Crawler $metricToLoad */
        foreach ($metricsToLoad as $metricToLoad) {
            if ($this->metricFactoryFactory->hasMetricFactory($metricToLoad->attr['type'])) {
                $metricFactory = $this->metricFactoryFactory->createMetricFactory($metricToLoad->attr['type']);
                $metric = $metricFactory->createMetric($metricToLoad->attr['name']);

                // @todo: this has to become Crawler instances to have possibility to use child nodes in metric nodes
                $metric->setData(array($metricToLoad->text()));

                $measurement->addMetric($metric);
            } else {
                // @todo: Add some logging here.
                continue;
            }
        }



        $data = array('testpost' => 'hurray');
        return $this->view($data, 200);
    }

    /**
     * @return View
     */
    public function getClientdataAction()
    {
        $data = array('testget' => 'hurray');
        return $this->view($data, 200);
    }
}
