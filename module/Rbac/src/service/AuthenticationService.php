<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 15:07
 */

namespace Rbac\Service;

use Doctrine\ORM\EntityManager;
use Rbac\Entity\User;
use Rbac\Service\Session\Storage;

class AuthenticationService
{
    protected $entityManager;
    protected $sessionStorage;
    protected $instanceIdentity;

    public function __construct(EntityManager $entityManager, Storage $sessionStorage)
    {
        $this->sessionStorage = $sessionStorage;
        $this->entityManager = $entityManager;
    }

    public function authenticate(array $data)
    {
        $this->sessionStorage->write($data['email']);
    }

    public function getIdentity()
    {
        return $this->sessionStorage->read();
    }

    public function hasIdentity():bool
    {
        return $this->sessionStorage->read() != null;
    }

    public function getInstance():?User
    {
        $mail =  $this->sessionStorage->read();
        $identity = $this->entityManager->getRepository(User::class)->findOneBy(['email'=>$mail]);
        return $identity;
    }

    public function getStorage():Storage
    {
        return $this->sessionStorage;
    }
}