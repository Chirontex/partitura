<?php
declare(strict_types=1);

namespace Partitura\Event\Form;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestDtoCreateEvent
 * @package Partitura\Event\Form
 */
abstract class RequestDtoCreateEvent extends FormEvent
{
    /** @var Request */
    protected $symfonyRequest;

    public function __construct(Request $symfonyRequest)
    {
        $this->symfonyRequest = $symfonyRequest;
    }

    /**
     * @return Request
     */
    public function getSymfonyRequest() : Request
    {
        return $this->symfonyRequest;
    }
}
