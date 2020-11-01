<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 11:51
 */

use \Rbac\Service\AuthManager;
use \Rbac\Service\Factory\AuthManagerFactory;

return [
    'service_manager' => [
        'factories' => [
            AuthManager::class=>AuthManagerFactory::class
        ],
    ],
];