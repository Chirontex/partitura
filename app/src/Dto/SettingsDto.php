<?php

declare(strict_types=1);

namespace Partitura\Dto;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class SettingsDto.
 */
class SettingsDto
{
    #[Serializer\Type('string')]
    #[Serializer\SerializedName('sitename')]
    protected ?string $sitename = null;

    #[Serializer\Type('bool')]
    #[Serializer\SerializedName('is_user_panel_available')]
    protected bool $isUserPanelAvailable = false;

    /** @var ArrayCollection<string, string> */
    #[Serializer\Type('ArrayCollection')]
    #[Serializer\SerializedName('routes')]
    protected ArrayCollection $routes;

    /** @var ArrayCollection<string, mixed> */
    #[Serializer\Type('ArrayCollection')]
    #[Serializer\SerializedName('user')]
    protected ArrayCollection $userData;

    public function getSitename(): string
    {
        return (string)$this->sitename;
    }

    /**
     *
     * @return $this
     */
    public function setSitename(string $sitename): static
    {
        $this->sitename = $sitename;

        return $this;
    }

    public function isUserPanelAvailable(): bool
    {
        return (bool)$this->isUserPanelAvailable;
    }

    /**
     *
     * @return $this
     */
    public function setUserPanelAvailable(bool $isUserPanelAvailable): static
    {
        $this->isUserPanelAvailable = $isUserPanelAvailable;

        return $this;
    }

    /**
     * @return ArrayCollection<string, string>
     */
    public function getRoutes(): ArrayCollection
    {
        if (!($this->routes instanceof ArrayCollection)) {
            $this->routes = new ArrayCollection();
        }

        return $this->routes;
    }

    /**
     * @param ArrayCollection<string, string> $routes
     *
     * @return $this
     */
    public function setRoutes(ArrayCollection $routes): static
    {
        $this->routes = $routes;

        return $this;
    }

    /**
     * @return ArrayCollection<string, mixed>
     */
    public function getUserData(): ArrayCollection
    {
        if (!($this->userData instanceof ArrayCollection)) {
            $this->userData = new ArrayCollection();
        }

        return $this->userData;
    }

    /**
     * @param ArrayCollection<string, mixed> $userData
     *
     * @return $this
     */
    public function setUserData(ArrayCollection $userData): static
    {
        $this->userData = $userData;

        return $this;
    }
}
