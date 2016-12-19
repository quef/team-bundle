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

    protected $admin;

    public function __construct($roles, $admin)
    {
        $this->admin = $admin;
        $this->roles = $roles;
    }

    /** @return array */
    public function getRoles()
    {
        return $this->roles;
    }

    public function getRolesWithAdmin()
    {
        return array_merge($this->getRoles(), [$this->admin]);
    }

    /** @return string */
    public function getAdminRole()
    {
        return $this->admin;
    }
}