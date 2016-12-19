<?php

namespace Quef\TeamBundle\Security\Permission;

use Quef\TeamBundle\Exception\PermissionsNotFoundException;

class PermissionProvider implements PermissionProviderInterface
{
    private $permissions;
    private $rolesConfiguration;
    private $adminRole;

    public function __construct($permissions, $rolesConfiguration, $adminRole)
    {
        $this->permissions = $permissions;
        $this->rolesConfiguration = $rolesConfiguration;
        $this->adminRole = $adminRole;
    }

    public function getPermissionsForRole($role)
    {
        if (!is_string($role)) {
            throw new \InvalidArgumentException('The role should be a string parameter');
        }

        if($this->adminRole === $role) {
            return $this->permissions;
        }

        if (!isset($this->rolesConfiguration[$role])) {
            throw new PermissionsNotFoundException(
                sprintf('The role %s is not defined in the roles configuration', $role));
        }

        return $this->rolesConfiguration[$role]['permissions'];
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

}