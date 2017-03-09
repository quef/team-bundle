<?php

namespace Quef\TeamBundle\Security\Permission;

use Quef\TeamBundle\Exception\PermissionsNotFoundException;
use Quef\TeamBundle\Security\Role\Role;
use Quef\TeamBundle\Security\Role\RoleHierarchyInterface;

class PermissionProvider implements PermissionProviderInterface
{
    private $permissions;
    private $rolesConfiguration;
    private $ownerRole;
    /** @var RoleHierarchyInterface */
    private $hierarchy;

    public function __construct($permissions, $rolesConfiguration, $ownerRole, RoleHierarchyInterface $hierarchy)
    {
        $this->permissions = $permissions;
        $this->rolesConfiguration = $rolesConfiguration;
        $this->ownerRole = $ownerRole;
        $this->hierarchy = $hierarchy;
    }

    public function getPermissionsForRole($role)
    {
        if (!is_string($role)) {
            throw new \InvalidArgumentException('The role should be a string parameter');
        }

        if($this->ownerRole === $role) {
            return $this->permissions;
        }

        if (!isset($this->rolesConfiguration[$role])) {
            throw new PermissionsNotFoundException(
                sprintf('The role %s is not defined in the roles configuration', $role));
        }

        $permissions = array();
        foreach ($this->hierarchy->getReachableRoles([new Role($role)]) as $hierarchyRole)
        {
            $permissions = array_merge($permissions, $this->rolesConfiguration[$hierarchyRole->getRole()]['permissions']);
        }

        return $permissions;
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

}