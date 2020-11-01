<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 12:26
 */

namespace Rbac\Service\Factory;


use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Rbac\Service\AuthenticationService;
use Rbac\Service\AuthManager;

class AuthManagerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $config = $container->get('Config');
        if (isset($config['access_filter'])){
            $config = $config['access_filter'];
        }else{
            $config = [
                'mode'=>'restrictive',
                'parameters'=>[],
            ];
        }

        $authService = $container->get(AuthenticationService::class);

        return new AuthManager($config, $authService);
    }

}