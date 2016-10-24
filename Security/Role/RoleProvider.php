<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 23/10/16
 * Time: 03:22
 */

namespace Quef\TeamBundle\Security\Role;


class RoleProvider implements RoleProviderInterface
{
    protected $roles;

    public function __construct($roles)
    {
        $this->roles = $roles;
    }

    /** @return array */
    public function getRoles()
    {
        return $this->roles;
    }
}