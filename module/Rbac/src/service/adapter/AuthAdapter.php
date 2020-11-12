<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 08/11/2020
 * Time: 17:41
 */

namespace Rbac\Service\Adapter;


use Doctrine\ORM\EntityManager;
use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\Result;
use Laminas\Crypt\Password\Bcrypt;
use Rbac\Entity\User;


class AuthAdapter implements AdapterInterface
{
    protected $entityManager;
    protected $email;
    protected $password;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    public function setEmail(string $email):AuthAdapter
    {
        $this->email=$email;
        return $this;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
        return $this;
    }

    public function authenticate()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email'=>$this->email]);
        if(!$user){
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                ['Invalid credentials.']);
        }

        $bcrypt = new Bcrypt();
        $passwordHash = $user->getPassword();

        if($bcrypt->verify($this->password, $passwordHash)){
            return new Result(
                Result::SUCCESS,
                $user->getEmail(),
                ['Authenticated successfully.']);
        }else{
            return new Result(
                Result::FAILURE_CREDENTIAL_INVALID,
                null,
                ['Invalid credentials.']);
        }

    }

}