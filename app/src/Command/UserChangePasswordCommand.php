<?php
declare(strict_types=1);

namespace Partitura\Command;

use Doctrine\Persistence\ManagerRegistry;
use Partitura\Dto\UserChangePasswordDto;
use Partitura\Entity\User;
use Partitura\Event\UserChangePasswordExecuteEvent;
use Partitura\Factory\ConsoleInputDto\UserChangePasswordDtoFactory;
use Partitura\Repository\UserRepository;
use Partitura\Service\User\PasswordSettingService;
use Partitura\Service\User\UserSavingService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Throwable;

/**
 * Class UserChangePasswordCommand
 * @package Partitura\Command
 */
class UserChangePasswordCommand extends Command
{
    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var UserChangePasswordDtoFactory */
    protected $userChangePasswordDtoFactory;

    /** @var UserRepository */
    protected $userRepository;

    /** @var PasswordSettingService */
    protected $passwordSettingService;

    /** @var UserSavingService */
    protected $userSavingService;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        UserChangePasswordDtoFactory $userChangePasswordDtoFactory,
        ManagerRegistry $registry,
        PasswordSettingService $passwordSettingService,
        UserSavingService $userSavingService
    ) {
        parent::__construct();

        $this->eventDispatcher = $eventDispatcher;
        $this->userChangePasswordDtoFactory = $userChangePasswordDtoFactory;
        $this->userRepository = $registry->getRepository(User::class);
        $this->passwordSettingService = $passwordSettingService;
        $this->userSavingService = $userSavingService;
    }

    /** {@inheritDoc} */
    protected function configure() : void
    {
        $this
            ->setName("partitura:user:change-password")
            ->setDescription("Set a new password to the user.")
            ->setHidden(false)
            ->setAliases(["partitura:change-password:user", "change-password:user", "user:change-password"])
            ->setHelp("Change user's password. Nothing more, nothing less.")
            ->addArgument(UserChangePasswordDto::USERNAME, InputArgument::REQUIRED, "Username. Required.")
            ->addArgument(UserChangePasswordDto::PASSWORD, InputArgument::REQUIRED, "Password. Required.");
    }

    /** {@inheritDoc} */
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        try {
            /** @var UserChangePasswordDto */
            $dto = $this->userChangePasswordDtoFactory->createByConsoleInput($input);

            $this->eventDispatcher->dispatch(new UserChangePasswordExecuteEvent($dto));

            $user = $this->userRepository->findByUsername($dto->getUsername());

            $this->passwordSettingService->setNewPassword($user, $dto->getPassword());
            $this->userSavingService->saveUser($user, true);
        } catch (Throwable $e) {
            $output->writeln($e->getMessage());

            return static::FAILURE;
        }

        $output->writeln(sprintf(
            "%s password changed successfully!",
            $input->getArgument(UserChangePasswordDto::USERNAME)
        ));

        return static::SUCCESS;
    }
}
