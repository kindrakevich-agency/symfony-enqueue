# Clean symfony 4.4 + enqueue commands demo

1. Clone repo
2. composer install
3. ./bin/console enqueue:consume --setup-broker -vvv
4. ./bin/console demo:enqueue

Check log file in var/log/dev.log
After run command ./bin/console demo:enqueue - enqueue execute producer->sendCommand(Commands::RUN_COMMAND, new RunCommand('demo:hello', ['77web']));
See: /src/Command/EnqueueCommand.php
