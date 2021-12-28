# Clean symfony 4.4 + enqueue commands demo

1. Clone repo
2. composer install
3. ./bin/console enqueue:consume --setup-broker -vvv
4. ./bin/console run:enqueue or navigate to /test

See: **src/Command/EnqueueCommand.php**

See: **src/Processor/TestSenderProcessor.php**

![symfony 4.4 + enqueue](/assets/images/profiler.png)
