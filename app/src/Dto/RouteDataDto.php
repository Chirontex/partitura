<?php

declare(strict_types=1);

namespace Partitura\Dto;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class RouteDataDto
 * @package Partitura\Dto
 */
class RouteDataDto
{
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("name")
     */
    protected string $name;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("view")
     */
    protected string $view;

    /**
     * @return string
     */
    public function getName() : string
    {
        return (string)$this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name) : static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getView() : string
    {
        return (string)$this->view;
    }

    /**
     * @param string $view
     *
     * @return $this
     */
    public function setView(string $view) : static
    {
        $this->view = $view;

        return $this;
    }
}
