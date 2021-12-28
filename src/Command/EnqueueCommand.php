<?php


namespace App\Command;


use Enqueue\AsyncCommand\Commands;
use Symfony\Component\Console\Input\ArrayInput;
use Enqueue\AsyncCommand\RunCommand;
use Enqueue\Client\ProducerInterface;
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

        parent::__construct('demo:enqueue');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = $this->getApplication()->find('demo:hello');
        $arguments = [
            'name'    => '77web',
            '--time'  => 'morning',
        ];
        $greetInput = new ArrayInput($arguments);
        // $this->producer->sendCommand(Commands::RUN_COMMAND, $command->run($greetInput, $output));
        $this->producer->sendCommand(Commands::RUN_COMMAND, new RunCommand('demo:hello', ['77web']));
        return 0;
    }
}
