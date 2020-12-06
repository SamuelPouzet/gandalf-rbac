<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 14/11/2020
 * Time: 13:28
 */

namespace Rbac\Service\Factory;


use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Rbac\Service\AuthenticationService;
use Rbac\Service\PermissionManager;

class PermissionManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $cache = $container->get('FilesystemCache');
        $entityManager = $container->get(EntityManager::class);
        $authService = $container->get(AuthenticationService::class);

        return new PermissionManager($entityManager,$authService, $cache);
    }

}