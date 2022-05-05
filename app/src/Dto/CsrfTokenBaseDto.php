<?php
declare(strict_types=1);

namespace Partitura\Dto;

/**
 * Class CsrfTokenBaseDto
 * @package Partitura\Dto
 */
class CsrfTokenBaseDto
{
    /** @var string */
    protected $tokenBase;

    /**
     * @return string
     */
    public function getTokenBase() : string
    {
        return (string)$this->tokenBase;
    }

    /**
     * @param string $tokenBase
     *
     * @return $this
     */
    public function setTokenBase(string $tokenBase) : static
    {
        $this->tokenBase = $tokenBase;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function toArray() : array
    {
        return ["token_base" => $this->tokenBase];
    }
}
