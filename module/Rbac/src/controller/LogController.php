<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 13:33
 */

namespace Rbac\Controller;


use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Rbac\Form\LogForm;
use Rbac\Service\AuthenticationService;

class LogController extends AbstractActionController
{
    protected $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function LogAction():ViewModel
    {
        $authForm = new LogForm('auth-form');

        if( $this->getRequest()->isPost() ){
            $post = $this->params()->fromPost();
            $authForm->setData($post);
            if($authForm->isValid()){
                $data = $authForm->getData();
                $this->authenticationService->authenticate($data);
            }
        }

        return new ViewModel([
            'form'=>$authForm,
        ]);
    }
}