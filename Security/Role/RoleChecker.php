<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 09/11/16
 * Time: 17:29
 */

namespace Quef\TeamBundle\Security\Role;


use Quef\TeamBundle\Model\TeamMemberInterface;

class RoleChecker implements RoleCheckerInterface
{
    /** @var RoleHierarchyInterface */
    private $hierarchy;
    /** @var RoleInterface */
    private $adminRole;

    public function __construct(RoleHierarchyInterface $hierarchy, $adminRole)
    {
        $this->hierarchy = $hierarchy;
        $this->adminRole = new Role($adminRole);
    }

    public function hasRole($role, TeamMemberInterface $member)
    {
        if($this->isAdmin($member)) {
            return true;
        }

        foreach($this->extractRoles($member) as $memberRole)
        {
            if ($role === $memberRole->getRole()) {
                return true;
            }
        }
        return false;
    }

    private function extractRoles(TeamMemberInterface $member)
    {
        $memberRoles = array(new Role($member->getTeamRole()));
        $roles = array();
        foreach ($this->hierarchy->getReachableRoles($memberRoles) as $role)
        {
            $roles[] = $role;
        }
        return $roles;
    }

    private function isAdmin(TeamMemberInterface $member)
    {
        return $this->adminRole->getRole() === $member->getTeamRole();
    }
}