<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 06/11/2020
 * Time: 21:16
 */

namespace Rbac\Entity;
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
}