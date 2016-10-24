<?php


namespace Quef\TeamBundle\Security\Role;

/**
 * RoleHierarchyInterface is the interface for a role hierarchy.
 */
interface RoleHierarchyInterface
{
    /**
     * Returns an array of all reachable roles by the given ones.
     *
     * Reachable roles are the roles directly assigned but also all roles that
     * are transitively reachable from them in the role hierarchy.
     *
     * @param RoleInterface[] $roles An array of directly assigned roles
     *
     * @return RoleInterface[] An array of all reachable roles
     */
    public function getReachableRoles(array $roles);
}
