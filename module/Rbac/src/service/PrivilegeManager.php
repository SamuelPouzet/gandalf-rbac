<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 11/11/2020
 * Time: 13:41
 */

namespace Rbac\Service;


use Doctrine\ORM\EntityManager;
use Rbac\Entity\Privilege;
use Rbac\Entity\Role;

class PrivilegeManager
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(array $data):void
    {
        $privilege = new Privilege();
        $privilege->setName($data['name'])
            ->setDescription($data['description'])
            ->setIsActive($data['is_active']);

        foreach ($data['roles'] as $role){
            $entity = $this->entityManager->getRepository(Role::class)->find($role);
            $entity->addPrivilege($privilege);
            $privilege->addRole($entity);
        }
        $this->entityManager->persist($privilege);
        $this->entityManager->flush();
    }

    public function update(array $data, Privilege $privilege):void
    {

        $privilege->setName($data['name'])
            ->setDescription($data['description'])
            ->setIsActive($data['is_active'])
            ->razRoles();

        foreach ($data['roles'] as $role){
            $entity = $this->entityManager->getRepository(Role::class)->find($role);
            $entity->addPrivilege($privilege);
            $privilege->addRole($entity);
        }
        $this->entityManager->persist($privilege);
        $this->entityManager->flush();
    }

}