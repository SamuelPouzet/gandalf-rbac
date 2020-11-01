<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 12:01
 */

namespace Rbac\Listener;


use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;
use Rbac\Service\AuthManager;

class AuthListener extends AbstractListenerAggregate
{

    protected $event;

    public function __construct(MvcEvent $event)
    {
        $this->event = $event;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_DISPATCH,
            [$this, 'checkAuth']
        );
    }

    public function checkAuth()
    {
        $routeMatch = $this->event->getRouteMatch();
        $controller = $this->event->getTarget();
        $controllerName = $routeMatch->getParam('controller', null);
        $actionName = $routeMatch->getParam('action', null);
        $actionName = str_replace('-', '', lcfirst(ucwords($actionName, '-')));
        $authManager = $this->event->getApplication()->getServiceManager()->get(AuthManager::class);

        $authManager->authenticate($controllerName, $actionName);

        die(var_dump($controllerName));
    }

}