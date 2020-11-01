<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    // Session configuration.
    'session_config' => [
        'cookie_lifetime'     => 3*60*60*1, // Session cookie will expire in 3 hours.
        'gc_maxlifetime'      => 3*60*60*24*30, // How long to store session data on server (for 3 months).
        'remember_me_seconds' =>  3*60*60*24*30, // How long to store remember_me session
        'cookie_secure' => false,
        'save_path' => __DIR__ . '/../../data/session',
        'use_cookies' => true,
    ],
    // Session manager configuration.
    'session_manager' => [
        // Session validators (used for security).
        'validators' => [
            \Laminas\Session\Validator\RemoteAddr::class,
            \Laminas\Session\Validator\HttpUserAgent::class,
        ]
    ],
    // Session storage configuration.
    'session_storage' => [
        'type' => \Laminas\Session\Storage\SessionArrayStorage::class
    ],
    'session_containers' => [
        \Laminas\Session\Container::class,
    ],
];
