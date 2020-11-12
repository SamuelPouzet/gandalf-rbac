<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 07/11/2020
 * Time: 14:40
 */

namespace Rbac\Controller;


use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Rbac\Entity\Privilege;
use Rbac\Form\PrivilegeForm;
use Rbac\Service\PrivilegeManager;

class PrivilegeController extends AbstractActionController
{
    protected $entityManager;

    protected $privilegeManager;

    public function __construct(EntityManager $entityManager, PrivilegeManager $privilegeManager)
    {
        $this->entityManager = $entityManager;
        $this->privilegeManager = $privilegeManager;
    }

    public function indexAction():ViewModel
    {
        $privileges = $this->entityManager->getRepository(Privilege::class)->findAll();
        return new ViewModel([
            'privileges'=>$privileges,
        ]);
    }

    public function newAction()
    {

        $form = new PrivilegeForm($this->entityManager, 'privilege_form');

        if($this->getRequest()->isPost()){
            $data = $this->params()->fromPost();
            $form->setData($data);

            if($form->isValid()){
                $data=$form->getData();
                $this->privilegeManager->add($data);
                $this->redirect()->toRoute('privilege');
            }
        }

        return new ViewModel([
            'form'=>$form,
        ]);

    }

    public function updateAction()
    {

        $id = (int)$this->params()->fromRoute('id', -1);
        $privilege = $this->entityManager->getRepository(Privilege::class)->find($id);

        if(!$privilege){
            throw new \Exception('privilege not found');
        }

        $form = new PrivilegeForm($this->entityManager, 'privilege_form');

        if($this->getRequest()->isPost()){
            $data = $this->params()->fromPost();
            $form->setData($data);

            if($form->isValid()){
                $data=$form->getData();
                $this->privilegeManager->update($data, $privilege);
                $this->redirect()->toRoute('privilege');
            }
        }

        $form->bind($privilege);

        return new ViewModel([
            'form'=>$form,
        ]);

    }

}