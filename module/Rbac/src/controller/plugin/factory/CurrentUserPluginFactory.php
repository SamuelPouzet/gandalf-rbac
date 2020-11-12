<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 12/11/2020
 * Time: 21:58
 */

namespace Rbac\Controller\Plugin\Factory;


use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Rbac\Controller\Plugin\CurrentUserPlugin;
use Rbac\Service\AuthenticationService;

class CurrentUserPluginFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $authenticationService = $container->get(AuthenticationService::class);

        return new CurrentUserPlugin($authenticationService);
    }

}