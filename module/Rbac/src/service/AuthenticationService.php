<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 15:07
 */

namespace Rbac\Service;

use Doctrine\ORM\EntityManager;

use Laminas\Authentication\Adapter;
use Laminas\Authentication\Storage;
use Rbac\Entity\User;

class AuthenticationService extends \Laminas\Authentication\AuthenticationService
{
    protected $entityManager;

    public function __construct(Storage\StorageInterface $storage = null, Adapter\AdapterInterface $adapter = null, EntityManager $entityManager)
    {
        parent::__construct($storage, $adapter);
        $this->entityManager = $entityManager;
    }

    public function getInstance():?User
    {
        $mail =  $this->storage->read();
        $identity = $this->entityManager->getRepository(User::class)->findOneBy(['email'=>$mail]);
        return $identity;
    }

}