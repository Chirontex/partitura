<?php

declare(strict_types=1);

namespace Partitura\Command;

use Partitura\Dto\CreateUserDto;
use Partitura\Event\UserCreateCommandExecuteEvent;
use Partitura\Factory\ConsoleInputDto\CreateUserDtoFactory;
use Partitura\Factory\UserFactory;
use Partitura\Log\Trait\LoggerAwareTrait;
use Partitura\Service\User\UserSavingService;
use Psr\Log\LoggerAwareInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Throwable;

/**
 * Class UserCreateCommand.
 */
class UserCreateCommand extends Command implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected const COMMAND_NAME = "partitura:user:create";

    public function __construct(
        protected UserSavingService $userSavingService,
        protected UserFactory $userFactory,
        protected CreateUserDtoFactory $createUserDtoFactory,
        protected EventDispatcherInterface $eventDispatcher
    ) {
        parent::__construct();
    }

    /** {@inheritDoc} */
    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription("Creates a new user.")
            ->setHidden(false)
            ->setAliases(["user:create", "create:user", "partitura:create:user"])
            ->setHelp("This command helps you to create a new user. Firstly must be used to create a root user.")
            ->addArgument(CreateUserDto::USERNAME, InputArgument::REQUIRED, "Username. Required. Must be unique.")
            ->addArgument(CreateUserDto::PASSWORD, InputArgument::REQUIRED, "Users's password. Required.")
            ->addArgument(CreateUserDto::ROLE, InputArgument::OPTIONAL, "User's role code. Optional. ROLE_USER by default.");
    }

    /** {@inheritDoc} */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            /** @var CreateUserDto */
            $dto = $this->createUserDtoFactory->createByConsoleInput($input);

            $this->eventDispatcher->dispatch(
                new UserCreateCommandExecuteEvent($dto)
            );

            $user = $this->userFactory->createUser($dto);

            $this->userSavingService->saveUser($user, true);
            $this->logger->warning(sprintf(
                "User \"%s\" with role \"%s\" has been created by \"%s\" command at %s.",
                $user->getUsername(),
                $dto->getRole(),
                self::COMMAND_NAME,
                $user->getDatetimeCreated()?->format("Y-m-d H:i:s")
            ));
        } catch (Throwable $e) {
            $output->writeln($e->getMessage());

            return static::FAILURE;
        }

        $output->writeln("User created successfully!");

        return static::SUCCESS;
    }
}
