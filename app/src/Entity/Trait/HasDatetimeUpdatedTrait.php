<?php
declare(strict_types=1);

namespace Partitura\Entity\Trait;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait HasDatetimeUpdatedTrait
 * @package Partitura\Entity\Trait
 */
trait HasDatetimeUpdatedTrait
{
    /**
     * @var null|DateTime
     * 
     * @ORM\Column(type="datetime", name="DATETIME_UPDATED", nullable=true)
     */
    protected $datetimeUpdated;

    /**
     * @return null|DateTime
     */
    public function getDatetimeUpdated() : ?DateTime
    {
        return $this->datetimeUpdated;
    }

    /**
     * @param DateTime $datetimeUpdated
     *
     * @return $this
     */
    public function setDatetimeUpdated(DateTime $datetimeUpdated) : static
    {
        $this->datetimeUpdated = $datetimeUpdated;

        return $this;
    }
}
