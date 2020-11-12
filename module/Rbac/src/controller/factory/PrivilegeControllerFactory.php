<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 07/11/2020
 * Time: 14:40
 */

namespace Rbac\Controller\Factory;


use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Rbac\Controller\PrivilegeController;
use Rbac\Service\PrivilegeManager;

class PrivilegeControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entitymanager = $container->get(EntityManager::class);
        $privilegeManager = $container->get(PrivilegeManager::class);
        return new PrivilegeController($entitymanager, $privilegeManager);
    }

}