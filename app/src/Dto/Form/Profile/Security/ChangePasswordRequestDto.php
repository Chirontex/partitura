<?php

declare(strict_types=1);

namespace Partitura\Dto\Form\Profile\Security;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ChangePasswordRequestDto
 */
class ChangePasswordRequestDto extends SecurityRequestDto
{
    #[Assert\NotBlank(message: 'Old password cannot be empty.')]
    #[SecurityAssert\UserPassword(message: 'Invalid old password.')]
    #[Serializer\Type('string')]
    #[Serializer\SerializedName('old_password')]
    protected ?string $oldPassword = null;

    #[Assert\NotBlank(message: 'New password cannot be empty.')]
    #[Assert\NotIdenticalTo(
        propertyPath: 'oldPassword',
        message: 'New password must not be the same as the old password.'
    )]
    #[Serializer\Type('string')]
    #[Serializer\SerializedName('new_password')]
    protected ?string $newPassword = null;

    public function getOldPassword(): string
    {
        return (string)$this->oldPassword;
    }

    /**
     *
     * @return $this
     */
    public function setOldPassword(string $oldPassword): static
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPassword(): string
    {
        return (string)$this->newPassword;
    }

    /**
     *
     * @return $this
     */
    public function setNewPassword(string $newPassword): static
    {
        $this->newPassword = $newPassword;

        return $this;
    }
}
