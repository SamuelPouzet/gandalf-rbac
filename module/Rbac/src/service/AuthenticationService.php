<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 15:07
 */

namespace Rbac\Service;

use Rbac\Service\Session\Storage;

class AuthenticationService
{
    protected $sessionStorage;

    public function __construct(Storage $sessionStorage)
    {
        $this->sessionStorage = $sessionStorage;
    }

    public function authenticate(array $data)
    {
        $this->sessionStorage->write($data['email']);
    }

    public function getIdentity()
    {
        return $this->sessionStorage->read();
    }

    public function getStorage():Storage
    {
        return $this->sessionStorage;
    }
}