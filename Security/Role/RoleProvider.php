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

    protected $owner;

    public function __construct($roles, $owner)
    {
        $this->owner = $owner;
        $this->roles = $roles;
    }

    /** @return array */
    public function getRoles()
    {
        return $this->roles;
    }

    public function getRolesWithOwner()
    {
        return array_merge($this->getRoles(), [$this->owner]);
    }

    /** @return string */
    public function getOwnerRole()
    {
        return $this->owner;
    }
}