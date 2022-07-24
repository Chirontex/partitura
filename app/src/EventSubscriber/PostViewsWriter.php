<?php
declare(strict_types=1);

namespace Partitura\EventSubscriber;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Partitura\Entity\Post;
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

        if (!$this->isPostViewWritingAvailable($post, $request)) {
            return;
        }

        try {
            $this->objectManager->persist(
                $this->postViewFactory->createByPostRequest($post, $request)
            );
            $this->objectManager->flush();
        } catch (PostViewException $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * @param Post $post
     * @param Request $request
     *
     * @return bool
     */
    protected function isPostViewWritingAvailable(Post $post, Request $request) : bool
    {
        if ($this->isItBotViewing($request)) {
            return false;
        }

        $clientIp = $request->getClientIp();
        $currentUser = $this->currentUserService->getCurrentUser();

        if (empty($clientIp) && !($currentUser instanceof User)) {
            $this->logger->error("Cannot find a previously wrote post views because client IP and current user are not found.");

            return false;
        }

        $criteria = ["post" => $post];

        if ($currentUser instanceof User) {
            $criteria["user"] = $currentUser;
        } else {
            $criteria["ipAddress"] = $clientIp;
        }

        $postViews = $this->postViewRepository->findBy($criteria);

        if (!$postViews->isEmpty()) {
            return false;
        }

        return true;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    protected function isItBotViewing(Request $request) : bool
    {
        $userAgent = (string)$request->server->get("HTTP_USER_AGENT");

        if (empty($userAgent)) {
            return false;
        }

        // TODO: Возможно, имеет смысл в будущем положить это в БД и дать пользователю возможность редактировать в админке.
        $botMarkers = [
            "APIs-Google",
            "AdsBot-Google",
            "Googlebot",
            "Mediapartners-Google",
            "YandexBot",
            "YandexAccessibilityBot",
            "YandexMobileBot",
            "YandexDirectDyn",
            "YandexImages",
            "YandexVideo",
            "YandexVideoParser",
            "YandexMedia",
            "YandexBlogs",
            "YandexFavicons",
            "YandexWebmaster",
            "YandexPagechecker",
            "YandexImageResizer",
            "YandexAdNet",
            "YandexDirect",
            "YaDirectFetcher",
            "YandexCalendar",
            "YandexSitelinks",
            "YandexMetrika",
            "YandexNews",
            "YandexCatalog",
            "YandexMarket",
            "YandexVertis",
            "YandexForDomain",
            "YandexSpravBot",
            "YandexSearchShop",
            "YandexMedianaBot",
            "YandexOntoDB",
            "YandexOntoDBAPI",
            "YandexVerticals",
            "Mail.RU_Bot",
            "StackRambler",
            "Yahoo! Slurp",
            "msnbot",
            "bingbot",
        ];

        foreach ($botMarkers as $marker) {
            if (strpos($userAgent, $marker) !== false) {
                return true;
            }
        }

        return false;
    }
}
