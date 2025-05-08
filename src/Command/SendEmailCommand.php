<?php

// src/Command/SendEmailCommand.php

namespace App\Command;

use App\Message\SendWelcomeEmail;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'app:send-email')]
class SendEmailCommand extends Command
{

    public function __construct(private readonly MessageBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Dispatch message from the command
        $this->bus->dispatch(new SendWelcomeEmail('user@example.com'));

        $output->writeln('Message dispatched!');

        return Command::SUCCESS;
    }
}
