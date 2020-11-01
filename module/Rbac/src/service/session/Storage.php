<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 01/11/2020
 * Time: 15:18
 */

namespace Rbac\Service\Session;


use Laminas\Session\Container;
use Laminas\Session\ManagerInterface;

class Storage
{
    const AUTHNAME = 'gandalf_default';

    const MEMBER = 'session';

    protected $authname;

    protected $member;

    protected $sessionManager;

    public function __construct($name = null, $member = null, ManagerInterface $sessionManager = null)
    {
        $this->authname = $name??self::AUTHNAME;

        $this->member = $member??self::MEMBER;

        $this->sessionManager = new Container($this->authname, $sessionManager);

    }

    public function write(string $contents):void
    {
        $this->sessionManager->{$this->member} = $contents;
    }

    public function read():string
    {
        return $this->sessionManager->{$this->member} ;
    }

}