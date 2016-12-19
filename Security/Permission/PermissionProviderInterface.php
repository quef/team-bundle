<?php

namespace Quef\TeamBundle\Security\Permission;

interface PermissionProviderInterface
{
    public function getPermissionsForRole($role);

    public function getPermissions();
}