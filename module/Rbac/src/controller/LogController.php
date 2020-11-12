<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 13:33
 */

namespace Rbac\Controller;


use Laminas\Authentication\Result;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Rbac\Form\LogForm;
use Rbac\Service\AuthenticationService;
use Rbac\Service\AuthManager;

class LogController extends AbstractActionController
{
    protected $authenticationService;

    public function __construct(AuthManager $authenticationService)
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
                $grant = $this->authenticationService->log($data);
                if( $grant->getCode() == Result::SUCCESS ){

                    if(! isset($data['redirect_url']) || $data['redirect_url'] == ''){
                        $redirectUrl = '/';
                    }else{
                        $redirectUrl = $data['redirect_url'];
                    }
                    $this->redirect()->toUrl($redirectUrl);
                }
            }
        }

        return new ViewModel([
            'form'=>$authForm,
        ]);
    }

    public function AccessDeniedAction():ViewModel
    {
        return new ViewModel([

        ]);
    }

    public function unlogAction():ViewModel
    {
        $this->authenticationService->unlog();
        $this->redirect()->toRoute('home');
    }
}