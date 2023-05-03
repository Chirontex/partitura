<?php

declare(strict_types=1);

namespace Partitura\Command;

use Doctrine\Persistence\ManagerRegistry;
use Partitura\Dto\UserChangePasswordDto;
use Partitura\Entity\User;
use Partitura\Event\UserChangePasswordExecuteEvent;
use Partitura\Factory\ConsoleInputDto\UserChangePasswordDtoFactory;
use Partitura\Log\Trait\LoggerAwareTrait;
use Partitura\Repository\UserRepository;
use Partitura\Service\User\PasswordSettingService;
use Partitura\Service\User\UserSavingService;
use Psr\Log\LoggerAwareInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Throwable;

/**
 * Class UserChangePasswordCommand.
 */
class UserChangePasswordCommand extends Command implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected const COMMAND_NAME = "partitura:user:change-password";

    /** @var UserRepository */
    protected $userRepository;

    public function __construct(
        ManagerRegistry $registry,
        UserChangePasswordDtoFactory $userChangePasswordDtoFactory,
        protected EventDispatcherInterface $eventDispatcher,
        protected PasswordSettingService $passwordSettingService,
        protected UserSavingService $userSavingService
    ) {
        parent::__construct($userChangePasswordDtoFactory);

        $this->userRepository = $registry->getRepository(User::class);
    }

    /** {@inheritDoc} */
    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription("Set a new password to the user.")
            ->setHidden(false)
            ->setAliases([
                "partitura:change-password:user",
                "partitura:user:change-password",
                "change-password:user",
                "user:change-password",
            ])
            ->setHelp("Change user's password. Nothing more, nothing less.")
            ->addArgument(UserChangePasswordDto::USERNAME, InputArgument::REQUIRED, "Username. Required.")
            ->addArgument(UserChangePasswordDto::PASSWORD, InputArgument::REQUIRED, "Password. Required.");
    }

    /**
     * @param UserChangePasswordDto $dto
     */
    protected function doExecute(object $dto): void
    {
        try {
            $this->eventDispatcher->dispatch(new UserChangePasswordExecuteEvent($dto));

            $user = $this->userRepository->findByUsername($dto->getUsername());

            $this->passwordSettingService->setNewPassword($user, $dto->getPassword());
            $this->userSavingService->saveUser($user, true);
            $this->logger->warning(sprintf(
                "Password of user \"%s\" has been changed by \"%s\" command at %s.",
                $user->getUsername(),
                self::COMMAND_NAME,
                $user->getDatetimeUpdated()?->format("Y-m-d H:i:s")
            ));
        } catch (Throwable $e) {
            $this->output->writeln($e->getMessage());

            throw $e;
        }

        $this->output->writeln(sprintf(
            "%s password changed successfully!",
            $dto->getUsername()
        ));
    }
}
