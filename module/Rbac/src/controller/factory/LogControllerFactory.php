<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 13:34
 */

namespace Rbac\Controller\Factory;


use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Rbac\Controller\LogController;
use Rbac\Service\AuthenticationService;

class LogControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authenticationManager = $container->get(AuthenticationService::class);
        return new LogController($authenticationManager);
    }

}