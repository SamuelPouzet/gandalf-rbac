<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 06/11/2020
 * Time: 21:16
 */

namespace Rbac\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Role
 * @package Rbac\Entity
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\Column(name="name")
     */
    protected $name;

    /**
     * @ORM\Column(name="is_active")
     */
    protected $is_active;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="users")
     */
    protected $users;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="children")
     * @ORM\JoinTable(name="role_hierarchy",
     *   joinColumns={@ORM\JoinColumn(name="id_parent", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="id_child", referencedColumnName="id")}
     * )
     */
    protected $parents;

    /**
     * @ORM\ManyToMany(targetEntity="Role", mappedBy="parents")
     */
    protected $children;

    /**
     * @ORM\ManyToMany(targetEntity="Privilege", inversedBy="roles", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="role_privilege",
     *   joinColumns={@ORM\JoinColumn(name="id_role", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="id_privilege", referencedColumnName="id")}
     * )
     */
    protected $privileges;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->parents = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->privileges = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Role
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getisActive()
    {
        return $this->is_active;
    }

    /**
     * @param mixed $is_active
     * @return Role
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
        return $this;
    }

    public function addPrivilege(Privilege $privilege):Role
    {
        $this->privileges[] = $privilege;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     * @return Role
     */
    public function setUsers($users)
    {
        $this->users = $users;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * @param mixed $parents
     * @return Role
     */
    public function setParents($parents)
    {
        $this->parents = $parents;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     * @return Role
     */
    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrivileges()
    {
        return $this->privileges;
    }

}