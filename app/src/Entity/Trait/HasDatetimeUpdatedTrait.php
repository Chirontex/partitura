<?php

declare(strict_types=1);

namespace Partitura\Entity\Trait;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait HasDatetimeUpdatedTrait
 */
trait HasDatetimeUpdatedTrait
{
    #[ORM\Column(type: 'datetime', name: 'DATETIME_UPDATED', nullable: true)]
    protected ?DateTime $datetimeUpdated = null;

    public function getDatetimeUpdated(): ?DateTime
    {
        return $this->datetimeUpdated;
    }

    /**
     *
     * @return $this
     */
    public function setDatetimeUpdated(DateTime $datetimeUpdated): static
    {
        $this->datetimeUpdated = $datetimeUpdated;

        return $this;
    }
}
