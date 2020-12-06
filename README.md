# Gandalf - Laminas RBAC Manager

## Introduction

This is a Role based access controller for Laminas

## Usage

In configuration

    'access_filter'=>[
        //can only be permissive or restrictive
        'mode'=>'restrictive',
        'parameters'=>[
            **controllerclass=>[
                **actionName**=> ['*'], // * grant to everyone
                **actionName2**=>['@'], // * grant to all connected users
                **actionName3**=>['+roleName'], // grant to one or more roles (with their children)
                **actionName4**=>['.permissionName'], // grant to one or more permissions
            ],
        ],
    ],
    
