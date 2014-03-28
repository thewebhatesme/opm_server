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
use Phm\Bundle\OpmServerBundle\Entity\Measurement;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\DomCrawler\Crawler;
use Phm\Bundle\OpmServerBundle\Entity\Client;

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
     * @var HttpMetricFactoryInterface
     */
    private $metricFactory;

    /**
     * Constructor
     */
    public function __construct(EntityManager $em, Crawler $domCrawler)
    {
        $this->em = $em;
        $this->domCrawler = $domCrawler;
        // $this->eventManager = $this->em->getEventManager();
    }

    /**
     * @return View
     */
    public function postClientdataAction($clientUuid, $data)
    {
        $client = new Client();
        $measurement = new Measurement();

        $this->domCrawler->addXmlContent($data);
        $metricsToLoad = $this->domCrawler
          ->filter(Measurement::XMLNODENAME)
          ->filter(Measurement::METRICSXMLNODENAME)
          ->each(function(Crawler $node, $position) {
                return $node->attr('name');
            });

        $this->metricFactory->

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
