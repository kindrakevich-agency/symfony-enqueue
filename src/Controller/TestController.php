<?php
namespace App\Controller;

use Enqueue\Client\ProducerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TestController extends AbstractController
{

    /**
     * @var ProducerInterface
     */
    private $producer;

    /**
     * FireEventService constructor.
     * @param ProducerInterface $producer
     */
    public function __construct(ProducerInterface $producer)
    {
        $this->producer = $producer;
    }

    /**
     * @Route("/test")
     */
    public function indexAction()
    {
        // Models array
        $models = [];

        // Get xml
        $crawler = new Crawler();
        $crawler->addXmlContent(file_get_contents('https://symfony.karpaty.rocks/xml/accessories.xml'));

        // Filter by model
        $crawler = $crawler->filterXPath('//model');

        // Add to Enqueue
        $crawler->each(function ($model, $i) use (&$models) {
          $models[] = 'Proccessed: '.$model->filter('title')->text();
          $this->producer->sendEvent("model_proccess", ['model' => $model->filter('title')->text()]);
        });

        $response = new JsonResponse($models);
        $response->setEncodingOptions( $response->getEncodingOptions() | JSON_PRETTY_PRINT );
        return $response;
    }
}
