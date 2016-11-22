<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 21/11/16
 * Time: 18:34
 */

namespace Quef\TeamBundle\Security\Permission;


interface RolePermissionCheckerInterface
{
    public function isAuthorized($role, $permission);
}
