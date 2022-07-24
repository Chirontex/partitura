<?php
declare(strict_types=1);

namespace Partitura\EventSubscriber;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Partitura\Entity\PostView;
use Partitura\Entity\User;
use Partitura\Event\PostViewEvent;
use Partitura\Exception\PostViewException;
use Partitura\Factory\PostViewFactory;
use Partitura\Log\Trait\LoggerAwareTrait;
use Partitura\Repository\PostViewRepository;
use Partitura\Service\User\CurrentUserService;
use Psr\Log\LoggerAwareInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PostViewsWriter
 * @package Partitura\EventSubscriber
 */
class PostViewsWriter implements EventSubscriberInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /** @var PostViewFactory */
    protected $postViewFactory;

    /** @var ObjectManager */
    protected $objectManager;

    /** @var PostViewRepository */
    protected $postViewRepository;

    /** @var CurrentUserService */
    protected $currentUserService;

    public function __construct(
        PostViewFactory $postViewFactory,
        ManagerRegistry $registry,
        CurrentUserService $currentUserService
    ) {
        $this->postViewFactory = $postViewFactory;
        $this->objectManager = $registry->getManager();
        $this->postViewRepository = $registry->getRepository(PostView::class);
        $this->currentUserService = $currentUserService;
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents() : array
    {
        return [PostViewEvent::class => "writePostView"];
    }

    /**
     * @param PostViewEvent $event
     */
    public function writePostView(PostViewEvent $event) : void
    {
        $post = $event->getPost();
        $request = Request::createFromGlobals();
        $clientIp = $request->getClientIp();
        $currentUser = $this->currentUserService->getCurrentUser();

        try {
            if (empty($clientIp) && !($currentUser instanceof User)) {
                throw new PostViewException("Cannot find a previously wrote post views because client IP and current user are not found.");
            }

            $criteria = ["post" => $post];

            if ($currentUser instanceof User) {
                $criteria["user"] = $currentUser;
            } else {
                $criteria["ipAddress"] = $clientIp;
            }

            $postViews = $this->postViewRepository->findBy($criteria);

            if (!$postViews->isEmpty()) {
                return;
            }

            $this->objectManager->persist(
                $this->postViewFactory->createByPostRequest($post, $request)
            );
            $this->objectManager->flush();
        } catch (PostViewException $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
