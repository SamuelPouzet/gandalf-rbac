<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 15:07
 */

namespace Rbac\Service\Factory;


use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\SessionManager;
use Rbac\Service\Session\Storage;
use Rbac\Service\AuthenticationService;

class AuthenticationServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $sessionManager = $container->get(SessionManager::class);
        $authStorage = new Storage('gandalfauthrbac', 'session', $sessionManager);

        return new AuthenticationService($authStorage);

    }

}