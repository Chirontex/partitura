<?php
declare(strict_types=1);

namespace Partitura\Command;

use Partitura\Dto\CreateUserDto;
use Partitura\Factory\CreateUserDtoFactory;
use Partitura\Factory\UserFactory;
use Partitura\Service\User\UserSavingService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

/**
 * Class UserCreateCommand
 * @package Partitura\Command
 */
class UserCreateCommand extends Command
{
    /** @var UserSavingService */
    protected $userSavingService;

    /** @var UserFactory */
    protected $userFactory;

    /** @var CreateUserDtoFactory */
    protected $createUserDtoFactory;

    public function __construct(
        UserSavingService $userSavingService,
        UserFactory $userFactory,
        CreateUserDtoFactory $createUserDtoFactory
    ) {
        parent::__construct();

        $this->userSavingService = $userSavingService;
        $this->userFactory = $userFactory;
        $this->createUserDtoFactory = $createUserDtoFactory;
    }

    /** {@inheritDoc} */
    protected function configure() : void
    {
        $this
            ->setName("partitura:user:create")
            ->setDescription("Creates a new user.")
            ->setHidden(false)
            ->setAliases(["user:create", "create:user", "partitura:create:user"])
            ->setHelp("This command helps you to create a new user. Firstly must be used to create a root user.")
            ->addArgument(CreateUserDto::USERNAME, InputArgument::REQUIRED, "Username. Required. Must be unique.")
            ->addArgument(CreateUserDto::PASSWORD, InputArgument::REQUIRED, "Users's password. Required.")
            ->addArgument(CreateUserDto::ROLE, InputArgument::OPTIONAL, "User's role code. Optional. ROLE_USER by default.");
    }

    /** {@inheritDoc} */
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        try {
            $user = $this->userFactory->createUser(
                $this->createUserDtoFactory->createByConsoleInput($input)
            );

            $this->userSavingService->saveUser($user, true);
        } catch (Throwable $e) {
            $output->writeln($e->getMessage());

            return static::FAILURE;
        }

        $output->writeln("User created successfully!");

        return static::SUCCESS;
    }
}
