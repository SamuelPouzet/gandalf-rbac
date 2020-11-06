<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 12:25
 */

namespace Rbac\Service;


class AuthManager
{

    const RESTRICTIVE = 'restrictive';

    protected $config;
    protected $authService;

    public function __construct(array $config, AuthenticationService $authService)
    {
        $this->config = $config;
        $this->authService = $authService;
    }

    public function authenticate($controllerName, $actionName)
    {
        $mode = $this->config['mode'];
        $parameters = $this->config['parameters'];
        $controllerConfig = $parameters[$controllerName]??null;

        if(is_null($controllerConfig)){
            if($mode == self::RESTRICTIVE){
                die('config not found');
            }else{
                die('bypass');
            }
        }

        $actionConfig = $controllerConfig[$actionName]??null;
        if(is_null($actionConfig)){
            if($mode == self::RESTRICTIVE){
                die('config not found for action');
            }else{
                die('bypass action');
            }
        }

        if(!is_array($actionConfig)){
            $actionConfig = [$actionConfig];
        }
        if(in_array('*', $actionConfig)){
            return true;
        }

        $this->getAuth($actionConfig);

        return true;

    }

    protected function getAuth(array $actionConfig)
    {
        $identity = $this->authService->getInstance();
        if(in_array("@", $actionConfig) && $identity ){
            return true;
        }

        $roles = $identity->getRoles();

        foreach ($actionConfig as $config){

            switch($config[0]){
                case '@':
                    $config = substr($config,1);
                    if($identity->getEmail() == $config){
                        return true;
                    }
                    break;
                case '+':
                    foreach ($roles as $role){
                        $config = substr($config,1);
                        if($role->getName() == $config){
                            return true;
                        }
                    }
                    break;

            }


        }
        die('try to authenticate');
    }

}