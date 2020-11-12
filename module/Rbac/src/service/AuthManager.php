<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 12:25
 */

namespace Rbac\Service;


use Laminas\Authentication\Result;

class AuthManager
{

    const RESTRICTIVE = 'restrictive';
    const NEED_CONNECTION = 0;
    const ACCESS_GRANTED = 1;
    const ACCESS_DENIED = 2;

    protected $config;
    protected $authService;

    public function __construct(array $config, AuthenticationService $authService)
    {
        $this->config = $config;
        $this->authService = $authService;
    }

    public function log(array $data):Result
    {
        if($this->authService->hasIdentity()){
            die('already logged in');
        }
        $adapter = $this->authService->getAdapter();
        $adapter->setEmail($data['email'])
            ->setPassword($data['password']);
        return $this->authService->authenticate();
    }

    public function unlog()
    {
        if( ! $this->authService->hasIdentity()){
            die('not connected');
        }
        $this->authService->clearIdentity();
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
            return self::ACCESS_GRANTED;
        }

        if(! $this->authService->hasIdentity()){
            return self::NEED_CONNECTION;
        }

        return $this->getAuth($actionConfig);

    }

    protected function getAuth(array $actionConfig)
    {
        $identity = $this->authService->getInstance();

        if(in_array("@", $actionConfig) && $identity ){
            return self::ACCESS_GRANTED;
        }

        $roles = $identity->getRoles();

        foreach ($actionConfig as $config){

            switch($config[0]){
                case '@':
                    $config = substr($config,1);
                    if($identity->getEmail() == $config){
                        return self::ACCESS_GRANTED;
                    }
                    break;
                case '+':
                    foreach ($roles as $role){
                        $config = substr($config,1);
                        if($role->getName() == $config){
                            return self::ACCESS_GRANTED;
                        }
                    }
                    break;

            }


        }
        return self::ACCESS_DENIED;
    }

}