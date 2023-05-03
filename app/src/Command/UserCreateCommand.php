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
use Symfony\Component\Console\Input\InputArgument;
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
        CreateUserDtoFactory $createUserDtoFactory,
        protected UserSavingService $userSavingService,
        protected UserFactory $userFactory,
        protected EventDispatcherInterface $eventDispatcher
    ) {
        parent::__construct($createUserDtoFactory);
    }

    /** {@inheritDoc} */
    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription("Creates a new user.")
            ->setHidden(false)
            ->setAliases([
                "partitura:create:user",
                "partitura:user:create",
                "user:create",
                "create:user",
            ])
            ->setHelp("This command helps you to create a new user. Firstly must be used to create a root user.")
            ->addArgument(CreateUserDto::USERNAME, InputArgument::REQUIRED, "Username. Required. Must be unique.")
            ->addArgument(CreateUserDto::PASSWORD, InputArgument::REQUIRED, "Users's password. Required.")
            ->addArgument(CreateUserDto::ROLE, InputArgument::OPTIONAL, "User's role code. Optional. ROLE_USER by default.");
    }

    /**
     * @param CreateUserDto $dto
     */
    protected function doExecute(object $dto): void
    {
        try {
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
            $this->output->writeln($e->getMessage());

            throw $e;
        }

        $this->output->writeln("User created successfully!");
    }
}
