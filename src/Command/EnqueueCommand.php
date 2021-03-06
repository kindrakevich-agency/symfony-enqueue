<?php

namespace App\Command;

use Enqueue\AsyncCommand\Commands;
use Symfony\Component\Console\Input\ArrayInput;
use Enqueue\AsyncCommand\RunCommand;
use Enqueue\Client\ProducerInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EnqueueCommand extends Command
{
    /**
     * @var ProducerInterface
     */
    private $producer;

    /**
     * @param ProducerInterface $producer
     */
    public function __construct(ProducerInterface $producer)
    {
        $this->producer = $producer;

        parent::__construct('run:enqueue');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
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

        $output->writeln('Total models: '.count($models));

        return 0;
    }
}
