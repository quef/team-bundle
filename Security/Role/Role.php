<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 18/10/16
 * Time: 14:30
 */

namespace Quef\TeamBundle\Security\Role;


class Role implements RoleInterface
{
    private $role;

    /**
     * Constructor.
     *
     * @param string $role The role name
     */
    public function __construct($role)
    {
        $this->role = (string) $role;
    }

    /**
     * {@inheritdoc}
     */
    public function getRole()
    {
        return $this->role;
    }

}