<?php
declare(strict_types=1);

namespace Partitura\Controller;

use Partitura\Interfaces\CsrfTokenBaseFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Abstract controller.
 * @package Partitura\Controller
 */
abstract class Controller extends AbstractController
{
    /** @var CsrfTokenBaseFactoryInterface */
    protected $csrfTokenBaseFactory;

    public function __construct(CsrfTokenBaseFactoryInterface $csrfTokenBaseFactory)
    {
        $this->csrfTokenBaseFactory = $csrfTokenBaseFactory;
    }

    /**
     * @param null|Request $request
     *
     * @return array<string, string>
     */
    protected function getCsrfTokenBase(?Request $request = null) : array
    {
        return $this->csrfTokenBaseFactory->create($request)->toArray();
    }
}
