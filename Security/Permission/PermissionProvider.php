<?php

namespace Quef\TeamBundle\Security\Permission;

use Quef\TeamBundle\Exception\PermissionsNotFoundException;

class PermissionProvider implements PermissionProviderInterface
{
    private $rolesConfiguration;

    public function __construct($rolesConfiguration)
    {
        $this->rolesConfiguration = $rolesConfiguration;
    }

    public function getPermissionsForRole($role)
    {
        if (!is_string($role)) {
            throw new \InvalidArgumentException('The role should be a string parameter');
        }

        if (!isset($this->rolesConfiguration[$role])) {
            throw new PermissionsNotFoundException(
                sprintf('The role %s is not defined in the roles configuration', $role));
        }

        return $this->rolesConfiguration[$role]['permissions'];
    }
}