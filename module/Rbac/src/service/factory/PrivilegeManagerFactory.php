<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 11/11/2020
 * Time: 13:41
 */

namespace Rbac\Service\Factory;


use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Rbac\Service\PrivilegeManager;

class PrivilegeManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get(EntityManager::class);
        return new PrivilegeManager($entityManager);
    }

}