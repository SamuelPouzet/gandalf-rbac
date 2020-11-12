<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 08/11/2020
 * Time: 17:42
 */

namespace Rbac\Service\Adapter\Factory;


use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Rbac\Service\Adapter\AuthAdapter;

class AuthAdapterFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get(EntityManager::class);

        return new AuthAdapter($entityManager);
    }

}