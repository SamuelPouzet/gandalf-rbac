<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 14/11/2020
 * Time: 13:20
 */

namespace Rbac\Service;


use Doctrine\ORM\EntityManager;
use Laminas\Cache\Storage\StorageInterface;
use Laminas\Permissions\Rbac\Rbac;
use Rbac\Entity\Role;
use Rbac\Entity\User;

class PermissionManager
{

    protected $cache;

    protected $rbac;

    protected $entityManager;

    protected $authService;

    protected $accesses=null;

    public function __construct(EntityManager $entityManager, AuthenticationService $authService, StorageInterface $cache)
    {

        $this->entityManager = $entityManager;

        $this->authService = $authService;

        $this->cache = $cache;

    }

    public function initCache($reset = false):bool
    {
        if($reset){
            $this->cache->removeItem('rbac_container');
        }

        if($this->accesses){
            return true;
        }

        $result = false;
        $this->rbac = $this->cache->getItem('rbac_container', $result);

        if(!$result){
            $rbac = new Rbac();
            $rbac->setCreateMissingRoles(true);

            $roles = $this->entityManager->getRepository(Role::class)->findBy([
                'is_active'=>1
            ]);

            foreach ($roles as $role){

                $roleName = $role->getName();
                $parentRolesNames = [];

                foreach($role->getParents() as $parent){
                    $parentRolesNames[] = $parent->getName();
                }

                $rbac->addRole($roleName, $parentRolesNames);

                foreach ($role->getPrivileges() as $privilege) {
                    $rbac->getRole($roleName)->addPermission($privilege->getName());
                }
            }
            $this->cache->setItem('rbac_container', $rbac);
            $this->rbac = $this->cache->getItem('rbac_container', $result);
        }
        return true;

    }

    public function isGranted(string $permission, ?User $user = null, array $params = null):bool
    {

        if($this->rbac == null){
            $this->initCache();
        }

        if(!$user){
            $user = $this->authService->getInstance();
        }


        if(!$user){
            throw new \Exception('user not found');
        }

        $roles = $user->getRoles();

        //die(\Doctrine\Common\Util\Debug::dump($user->getRoles()));

        foreach ($roles as $role) {
            if ($this->rbac->isGranted($role->getName(), $permission)) {

                if ($params==null)
                    return true;

                foreach ($this->assertionManagers as $assertionManager) {
                    if ($assertionManager->assert($this->rbac, $permission, $params))
                        return true;
                }
            }

            // Since we are pulling the user from the database again the init() function above is overridden?
            // we don't seem to be taking into account the parent roles without the following code
            $parentRoles = $role->getParents();
            foreach ($parentRoles as $parentRole) {
                if ($this->rbac->isGranted($parentRole->getName(), $permission)) {
                    return true;
                }
            }
        }

        return false;

    }


}