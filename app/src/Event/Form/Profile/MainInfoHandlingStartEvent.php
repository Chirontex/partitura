<?php
declare(strict_types=1);

namespace Partitura\Event\Form\Profile;

use Partitura\Event\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MainInfoHandlingStartEvent
 * @package Partitura\Event\Form\Profile
 */
class MainInfoHandlingStartEvent extends FormEvent
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
