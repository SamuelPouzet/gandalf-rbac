<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 11:47
 */
declare(strict_types=1);
namespace Rbac;

use Laminas\Mvc\MvcEvent;
use Laminas\Session\SessionManager;
use Rbac\Listener\AuthListener;

class Module
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event) : void
    {
        $application = $event->getApplication();
        $eventManager = $application->getEventManager();

        $serviceManager = $application->getServiceManager();

        // The following line instantiates the SessionManager and automatically
        // makes the SessionManager the 'default' one to avoid passing the
        // session manager as a dependency to other models.
        $sessionManager = $serviceManager->get(SessionManager::class);

        $listener = new AuthListener($event);
        $listener->attach($eventManager);


    }

}