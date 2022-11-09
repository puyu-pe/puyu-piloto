<?php

namespace App\Saas\User\Infrastructure\Console;

use App\Saas\User\Application\Command\Create\CreateUserCommand as ApplicationCreateUserCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class CreateUserCommand extends Command
{
    public function __construct(private readonly CommandBus $commandBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('app:create-user')
            ->setDescription('Create a new user');

        $this->addArgument('username', InputArgument::REQUIRED, 'Username');
        $this->addArgument('password', InputArgument::REQUIRED, 'Password');
        $this->addArgument('fullName', InputArgument::REQUIRED, 'FullName');
        $this->addArgument('enabled', InputArgument::REQUIRED, 'If is an active user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $lastName = $input->getArgument('fullName');
        $enabled = $input->getArgument('enabled');

        try {
            $this->commandBus->dispatch(
                new ApplicationCreateUserCommand(
                    $username,
                    $password,
                    $lastName,
                    $enabled
                )
            );

            $output->writeln("<info>User: $username created.</info>");
        } catch (HandlerFailedException $e) {
            $errorMessage = $e->getPrevious()->getMessage();
            $output->writeln("<error>$errorMessage</error>");
        }

        return Command::SUCCESS;
    }
}