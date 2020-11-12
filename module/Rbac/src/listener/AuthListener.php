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
        $controllerName = $routeMatch->getParam('controller', null);
        $actionName = $routeMatch->getParam('action', null);
        $actionName = str_replace('-', '', lcfirst(ucwords($actionName, '-')));
        $authManager = $this->event->getApplication()->getServiceManager()->get(AuthManager::class);

        $response = $authManager->authenticate($controllerName, $actionName);

        switch($response){
            case AuthManager::NEED_CONNECTION:
                $this->event->getTarget()->redirect()->toRoute('log');
                break;
            case AuthManager::ACCESS_DENIED:
                //avoid loop redirection
                if($controllerName != 'log' ){
                    $this->event->getTarget()->redirect()->toRoute('access_denied');
                }
                break;
        }

    }

}