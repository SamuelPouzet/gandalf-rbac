<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 15:07
 */

namespace Rbac\Service\Factory;


use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\Authentication\Storage\Session;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\SessionManager;
use Rbac\Service\Adapter\AuthAdapter;
use Rbac\Service\AuthenticationService;

class AuthenticationServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $sessionManager = $container->get(SessionManager::class);
        $authStorage = new Session('gandalfauthrbac', 'session', $sessionManager);

        $authAdapter = $container->get(AuthAdapter::class);

        $entityManager = $container->get(EntityManager::class);

        return new AuthenticationService( $authStorage, $authAdapter, $entityManager);

    }

}