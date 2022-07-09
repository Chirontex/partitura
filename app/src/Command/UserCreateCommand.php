<?php
declare(strict_types=1);

namespace Partitura\Command;

use Partitura\Enum\RoleEnum;
use Partitura\Factory\UserFactory;
use Partitura\Service\User\UserSavingService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UserCreateCommand
 * @package Partitura\Command
 */
class UserCreateCommand extends Command
{
    protected const USERNAME = "username";
    protected const PASSWORD = "password";
    protected const ROLE = "role";

    /** @var UserSavingService */
    protected $userSavingService;

    /** @var UserFactory */
    protected $userFactory;

    public function __construct(UserSavingService $userSavingService, UserFactory $userFactory)
    {
        $this->userSavingService = $userSavingService;
        $this->userFactory = $userFactory;

        parent::__construct();
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
            ->addArgument(static::USERNAME, InputArgument::REQUIRED, "Username. Required. Must be unique.")
            ->addArgument(static::PASSWORD, InputArgument::REQUIRED, "Users's password. Required.")
            ->addArgument(static::ROLE, InputArgument::OPTIONAL, "User's role code. Optional. ROLE_USER by default.");
    }

    /** {@inheritDoc} */
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $roleCode = (string)$input->getArgument(static::ROLE);
        $user = $this->userFactory->createUser(
            (string)$input->getArgument(static::USERNAME),
            (string)$input->getArgument(static::PASSWORD),
            empty($roleCode) ? RoleEnum::ROLE_USER->value : $roleCode
        );

        $this->userSavingService->saveUser($user, true);

        $output->writeln("User created successfully!");

        return static::SUCCESS;
    }
}
