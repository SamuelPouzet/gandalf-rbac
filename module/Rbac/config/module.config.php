<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 11:51
 */

namespace Rbac;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Router\Http\Segment;
use Rbac\Controller\Factory\LogControllerFactory;
use Rbac\Controller\Factory\PrivilegeControllerFactory;
use Rbac\Controller\Plugin\CurrentUserPlugin;
use Rbac\Controller\Plugin\Factory\CurrentUserPluginFactory;
use Rbac\Controller\PrivilegeController;
use Rbac\Service\Adapter\AuthAdapter;
use Rbac\Service\Adapter\Factory\AuthAdapterFactory;
use Rbac\Service\AuthenticationService;
use \Rbac\Service\AuthManager;
use Rbac\Service\Factory\AuthenticationServiceFactory;
use \Rbac\Service\Factory\AuthManagerFactory;
use \Laminas\Router\Http\Literal;
use Rbac\Controller\LogController;
use Rbac\Service\Factory\PermissionManagerFactory;
use Rbac\Service\Factory\PrivilegeManagerFactory;
use Rbac\Service\PermissionManager;
use Rbac\Service\PrivilegeManager;

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
            'unlog'=>[
                'type'=>Literal::class,
                'options' => [
                    'route'    => '/unlog',
                    'defaults' => [
                        'controller' => LogController::class,
                        'action'     => 'unlog',
                    ],
                ],
            ],
            'privilege'=>[
                'type'=>Segment::class,
                'options' => [
                    'route'    => '/privilege[/:action[/:id]]',
                    'defaults' => [
                        'controller' => PrivilegeController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'access_denied'=>[
                'type'=>Literal::class,
                'options' => [
                    'route'    => '/access_denied',
                    'defaults' => [
                        'controller' => LogController::class,
                        'action'     => 'access_denied',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            LogController::class => LogControllerFactory::class,
            PrivilegeController::class=>PrivilegeControllerFactory::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            CurrentUserPlugin::class=>CurrentUserPluginFactory::class,
        ],
        'aliases' => [
            'currentUser'=>CurrentUserPlugin::class,
        ]
    ],
    'access_filter'=>[
        //can only be permissive or restrictive
        'mode'=>'restrictive',
        'parameters'=>[
            LogController::class=>[
                'log'=> '*',
                'access_denied'=>'*',
                'unlog'=>'*',
            ],
            PrivilegeController::class=>[
                'index'=> ['+role.admin'],
                'new'=> ['+role.admin'],
                'update'=> ['+role.admin'],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            AuthManager::class=>AuthManagerFactory::class,
            AuthenticationService::class=>AuthenticationServiceFactory::class,
            AuthAdapter::class=>AuthAdapterFactory::class,
            PrivilegeManager::class=>PrivilegeManagerFactory::class,
            PermissionManager::class=>PermissionManagerFactory::class,
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