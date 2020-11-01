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

class LogController extends AbstractActionController
{

    public function __construct()
    {

    }

    public function LogAction():ViewModel
    {
        $authForm = new LogForm('auth-form');

        return new ViewModel([
            'form'=>$authForm,
        ]);
    }
}