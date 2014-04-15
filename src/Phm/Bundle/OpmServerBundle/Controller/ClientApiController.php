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
use Phm\Component\Validator\ValidationResultInterface;
use Phm\Component\Validator\XmlValidationResult;
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
        $xmlDocument = new \DOMDocument();
        $xmlDocument->loadXML($request->getContent());

        $validationResult = $this->isValid($xmlDocument);
        if ($validationResult->hasErrors()) {
            // HTTP Status Code 422 = Unprocessable Entity
            return $this->view($validationResult->toString(), 422);
        }

        $this->domCrawler->addDocument($xmlDocument);
        $client = $this->storageStrategy->createClientItem();
        $client->setClientId($clientUuid);

        $measurement = $this->storageStrategy->createMeasurementItem();
        $measurement->setClientUuid($clientUuid);
        $measurement->setClient($client);

        $clientData = $this->domCrawler
          ->filterXpath('//testresult/' . Client::XMLNODENAME);
        $client->setDuration($clientData->filterXpath('//' . Client::XMLDURATIONNODENAME)->text());
        $client->setVersion($clientData->filterXpath('//' .Client::XMLVERSIONNODENAME)->text());
        $client->setLastactivity(new \DateTime($clientData->filterXpath('//' .Client::XMLSTARTNODENAME)->text()));

        $metricsToLoad = $this->domCrawler
          ->filterXpath('//testresult/' . Measurement::XMLNODENAME . '/' . Measurement::METRICSXMLNODENAME);
        /** @var \DomElement $metricToLoad */
        foreach ($metricsToLoad->children() as $metricToLoad) {
            // @todo: milo-04072014: the whole block needs more defensive programming and error handling
            $factoryType = $metricToLoad->attributes->getNamedItem(MetricInterface::TYPEXMLNODEATTRIBUTE)->nodeValue;
            $metricName = $metricToLoad->attributes->getNamedItem(MetricInterface::NAMEXMLNODEATTRIBUTE)->nodeValue;

            if ($this->metricFactoryFactory->hasMetricFactory($factoryType)) {
                $metricFactory = $this->metricFactoryFactory->createMetricFactory($factoryType);
                $metric = $metricFactory->createMetric($metricName);
                $metric->setData($metricToLoad->childNodes);
                $measurement->addMetric($metric);
            } else {
                // @todo: Add some logging here.
                continue;
            }
        }

        $this->storageStrategy->storeItems(array($measurement));

        // Maybe a 201 with location header heading to the created data or an xml document containing that information
        // HTTP No Content
        return $this->view(null, 204);
    }

    /**
     * @Get("/clients/{clientUuid}/measurements", name="get_client_measurements",
     *      requirements={"clientUuid" = "\d+"})
     *
     * @return View
     */
    public function getClientMeasurementsAction($clientUuid)
    {
        $data = array('Ok');
        return $this->view($data, 200);
    }

    /**
     * Create a client for an Ip or IP-
     *
     * @Get("/clients/create", name="get_clients_uuid")
     *
     * @return View
     */
    public function generateClientUuidAction()
    {
        // $client = $this->storageStrategy->createClientItem();
        $uuid = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
        // $client->setClientUuid($uuid);
        return $this->view($uuid, 200);
    }

    /**
     * @todo: milo-04102014-move to validator and let the validator collect all schemas and merge them into one file
     *
     * @param \DomDocument $domDocument
     *
     * @return ValidationResultInterface
     */
    private function isValid(\DomDocument $domDocument)
    {
        $result = new XmlValidationResult();
        if (false === $isValid = $domDocument->schemaValidate(__DIR__ . '/../../../Component/schema/opmserver-1.0.xsd')
        ) {
            $result->setErrors(libxml_get_errors());
        }

        return $result;
    }
}
