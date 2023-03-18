<?php
declare(strict_types=1);

namespace Partitura\Entity\Trait;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait HasDatetimeCreatedTrait
 * @package Partitura\Entity\Trait
 */
trait HasDatetimeCreatedTrait
{
    #[ORM\Column(type: 'datetime', name: 'DATETIME_CREATED')]   
    protected ?DateTime $datetimeCreated = null;

    /**
     * @return null|DateTime
     */
    public function getDatetimeCreated() : ?DateTime
    {
        return $this->datetimeCreated;
    }

    /**
     * @param DateTime $datetimeCreated
     *
     * @return $this
     */
    public function setDateTimeCreated(DateTime $datetimeCreated) : static
    {
        $this->datetimeCreated = $datetimeCreated;

        return $this;
    }
}
