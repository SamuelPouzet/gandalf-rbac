<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 12/11/2020
 * Time: 21:58
 */

namespace Rbac\Controller\Plugin;


use Laminas\Mvc\Controller\Plugin\AbstractPlugin;
use Rbac\Service\AuthenticationService;

class CurrentUserPlugin  extends AbstractPlugin
{

    protected $authenticationService;
    protected $currentUser;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function __invoke()
    {

        if($this->currentUser){
            return $this->currentUser;
        }

        $this->currentUser = $this->authenticationService->getInstance();
        return $this->currentUser;
    }

}