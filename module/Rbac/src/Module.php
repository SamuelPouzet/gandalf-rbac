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

        $listener = new AuthListener();
        $listener->attach($eventManager);
    }

}