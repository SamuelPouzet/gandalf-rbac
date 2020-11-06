<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 11:51
 */

namespace Rbac;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Rbac\Controller\Factory\LogControllerFactory;
use Rbac\Service\AuthenticationService;
use \Rbac\Service\AuthManager;
use Rbac\Service\Factory\AuthenticationServiceFactory;
use \Rbac\Service\Factory\AuthManagerFactory;
use \Laminas\Router\Http\Literal;
use Rbac\Controller\LogController;

return [
    'router'=>[
        'routes' => [
            'log'=>[
                'type'=>Literal::class,
                'options' => [
                    'route'    => '/log',
                    'defaults' => [
                        'controller' => LogController::class,
                        'action'     => 'log',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            LogController::class => LogControllerFactory::class,
        ],
    ],
    'access_filter'=>[
        //can only be permissive or restrictive
        'mode'=>'restrictive',
        'parameters'=>[
            LogController::class=>[
                'log'=> '*',
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            AuthManager::class=>AuthManagerFactory::class,
            AuthenticationService::class=>AuthenticationServiceFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ]
];