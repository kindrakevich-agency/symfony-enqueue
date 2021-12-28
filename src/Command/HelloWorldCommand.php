<?php


namespace App\Command;


use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorldCommand extends Command
{
    const TIME_MORNING = 'morning';
    const TIME_EVENING = 'evening';

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

        parent::__construct('demo:hello');
    }

    protected function configure()
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'name to say hello')
            ->addOption('time', null, InputOption::VALUE_OPTIONAL, 'what time is it?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $greeting = sprintf('%s, %s!', $this->resolveGreeting($input->getOption('time')), $input->getArgument('name'));
        $this->logger->info($greeting);

        $output->writeln($greeting);
        return 0;
    }

    private function resolveGreeting(?string $time): string
    {
        switch ($time) {
            case self::TIME_MORNING:
                return 'Good morning';
            case self::TIME_EVENING:
                return 'Good evening';
            default:
                return 'Hello';
        }
    }
}
