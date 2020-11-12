<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 07/11/2020
 * Time: 15:33
 */

namespace Rbac\Form;


use Doctrine\ORM\EntityManager;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Form;
use Rbac\Entity\Role;

class PrivilegeForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager, $name = null, array $options = [])
    {
        parent::__construct($name, $options);
        $this->entityManager = $entityManager;
        $this->addElements();
    }



    protected function addElements()
    {
        $this->add([
            'type'  => Text::class,
            'name' => 'name',
            'options' => [
                'label' => 'Name',
            ],
        ]);

        $this->add([
            'type'  => Select::class,
            'name' => 'is_active',
            'options' => [
                'label' => 'Enabled',
                'value_options'=>[
                    0=>'Disabled',
                    1=>"Actived",
                ]
            ],
        ]);

        $this->add([
            'type'  => Textarea::class,
            'name' => 'description',
            'options' => [
                'label' => 'Description',
            ],
        ]);

        $roles = $this->entityManager->getRepository(Role::class)->findBy(['is_active'=>1]);
        $arrayRole = [];
        foreach ($roles as $role){
            $arrayRole[$role->getId()] = $role->getName();
        }
        $this->add([
            'name'=> 'roles',
            'type'  => Select::class,

            'attributes' => [
                'multiple' => 'multiple'
            ],
            'options' => [
                'label' => 'Description',
                'value_options'=>$arrayRole,
                'selected_options'=>[1]
            ],
        ]);

        // Add the CSRF field
        $this->add([
            'type' => Csrf::class,
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 600
                ]
            ],
        ]);

        // Add the Submit button
        $this->add([
            'type'  => Submit::class,
            'name' => 'submit',
            'attributes' => [
                'value' => 'Change',
                'id' => 'submit',
            ],
        ]);
    }
}