<?php
declare(strict_types=1);

namespace Partitura\Event\PostsLoading;

/**
 * Class BeforeEvent
 * @package Partitura\Event\PostsLoading
 */
class BeforeEvent extends AfterEvent
{
    protected bool $skipPostsLoader = false;

    /**
     * @return bool
     */
    public function skipPostsLoader() : bool
    {
        return $this->skipPostsLoader;
    }

    /**
     * @param bool $skipPostsLoader
     *
     * @return $this
     */
    public function setSkipPostsLoader(bool $skipPostsLoader) : static
    {
        $this->skipPostsLoader = $skipPostsLoader;

        return $this;
    }
}
