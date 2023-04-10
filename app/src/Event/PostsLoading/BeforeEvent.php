<?php

declare(strict_types=1);

namespace Partitura\Event\PostsLoading;

/**
 * Class BeforeEvent.
 */
class BeforeEvent extends AfterEvent
{
    protected bool $skipPostsLoader = false;

    public function skipPostsLoader(): bool
    {
        return $this->skipPostsLoader;
    }

    /**
     *
     * @return $this
     */
    public function setSkipPostsLoader(bool $skipPostsLoader): static
    {
        $this->skipPostsLoader = $skipPostsLoader;

        return $this;
    }
}
