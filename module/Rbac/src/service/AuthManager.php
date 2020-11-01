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
    protected $config;
    const RESTRICTIVE = 'restrictive';

    public function __construct(array $config)
    {
        $this->config = $config;
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
            die('bypass, everything OK');
        }

        $this->getAuth($actionConfig);

        var_dump($this->config);die;
    }

    protected function getAuth(array $actionConfig)
    {
        die('try to authenticate');
    }

}