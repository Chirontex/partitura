<?php

declare(strict_types=1);

namespace Partitura\Event\Form\Profile;

use Partitura\Event\Form\RequestDtoHandleEvent;

/**
 * Class MainInfoHandlingProcessEvent.
 */
class MainInfoHandlingProcessEvent extends RequestDtoHandleEvent
{
    /**
     * @param array<string, string> $fields
     *
     * @return $this
     */
    public function setFieldsToResponseParameters(array $fields): static
    {
        $this->responseParameters->set("fields", $fields);

        return $this;
    }
}
