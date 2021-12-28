<?php

namespace App\Processor;

use Psr\Log\LoggerInterface;
use Interop\Queue\Message;
use Interop\Queue\Context;
use Interop\Queue\Processor;
use Enqueue\Client\TopicSubscriberInterface;

class TestSenderProcessor implements Processor, TopicSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function process(Message $message, Context $session)
    {

        $json = json_decode($message->getBody(), true);

        echo $message->getBody();

        return self::ACK;
    }

    public static function getSubscribedTopics()
    {
        return ['model_proccess'];
    }
}
