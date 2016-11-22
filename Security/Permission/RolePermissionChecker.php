<?php

namespace Quef\TeamBundle\Security\Permission;

class RolePermissionChecker implements RolePermissionCheckerInterface
{
    private $permissionProvider;

    public function __construct(PermissionProviderInterface $permissionProvider)
    {
        $this->permissionProvider = $permissionProvider;
    }

    public function isAuthorized($role, $permission)
    {
        $permissions  = $this->permissionProvider->getPermissionsForRole($role);

        if (in_array($permission, $permissions)) {
            return true;
        }

        return false;
    }
}
