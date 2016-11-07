<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 23/10/16
 * Time: 03:21
 */

namespace Quef\TeamBundle\Security\Role;


interface RoleProviderInterface
{
    /** @return array */
    public function getRoles();

    /** @return string */
    public function getAdminRole();
}