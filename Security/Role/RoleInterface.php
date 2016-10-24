<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 18/10/16
 * Time: 14:30
 */

namespace Quef\TeamBundle\Security\Role;


interface RoleInterface
{
    /**
     * Returns the role.
     *
     * This method returns a string representation whenever possible.
     *
     * When the role cannot be represented with sufficient precision by a
     * string, it should return null.
     *
     * @return string|null A string representation of the role, or null
     */
    public function getRole();
}