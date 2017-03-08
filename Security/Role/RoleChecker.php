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
    private $ownerRole;

    public function __construct(RoleHierarchyInterface $hierarchy, $ownerRole)
    {
        $this->hierarchy = $hierarchy;
        $this->ownerRole = new Role($ownerRole);
    }

    public function hasRole($role, TeamMemberInterface $member)
    {
        if($this->isOwner($member)) {
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

    private function isOwner(TeamMemberInterface $member)
    {
        return $this->ownerRole->getRole() === $member->getTeamRole();
    }
}