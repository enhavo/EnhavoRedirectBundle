<?php
/**
 * RedirectSubscriber.php
 *
 * @since 02/02/18
 * @author gseidel
 */

namespace Enhavo\Bundle\RedirectBundle\EventListener;

use Enhavo\Bundle\RedirectBundle\Model\RedirectInterface;
use Enhavo\Bundle\RedirectBundle\Redirect\RedirectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;

class RedirectSubscriber implements EventSubscriberInterface
{
    /**
     * @var RedirectManager
     */
    private $redirectManager;

    public function __construct(RedirectManager $redirectManager)
    {
        $this->redirectManager = $redirectManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'enhavo_redirect.redirect.pre_create' => 'preSave',
            'enhavo_redirect.redirect.pre_update' => 'preSave'
        );
    }

    public function preSave(ResourceControllerEvent $event)
    {
        $resource = $event->getSubject();
        if($resource instanceof RedirectInterface) {
            $this->redirectManager->update($resource);
        }
    }
}