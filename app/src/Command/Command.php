<?php

declare(strict_types=1);

namespace Partitura\Command;

use Partitura\Factory\ConsoleInputDto\AbstractConsoleInputDtoFactory;
use Symfony\Component\Console\Command\Command as BasicCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

abstract class Command extends BasicCommand
{
    protected InputInterface $input;

    protected OutputInterface $output;

    public function __construct(
        protected AbstractConsoleInputDtoFactory $consoleInputDtoFactory,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;

        try {
            $this->doExecute(
                $this->consoleInputDtoFactory->createByConsoleInput($input)
            );
        } catch (Throwable) {
            return static::FAILURE;
        }

        return static::SUCCESS;
    }

    abstract protected function doExecute(object $dto): void;
}
