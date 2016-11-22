<?php

namespace Quef\TeamBundle\Security\Permission;

use Quef\TeamBundle\Model\TeamMemberInterface;

class TeamMemberPermissionChecker implements TeamMemberPermissionCheckerInterface
{
    private $rolePermissionChecker;

    public function __construct(
        RolePermissionCheckerInterface $rolePermissionChecker
    ) {
        $this->rolePermissionChecker = $rolePermissionChecker;
    }

    public function isAuthorized(TeamMemberInterface $teamMember, $permission)
    {
        $role = $teamMember->getTeamRole();

        return $this->rolePermissionChecker->isAuthorized($role, $permission);
    }
}
