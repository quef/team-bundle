<?php

namespace Quef\TeamBundle\Security\Permission;

use Quef\TeamBundle\Model\TeamMemberInterface;

interface TeamMemberPermissionCheckerInterface
{
    public function isAuthorized(TeamMemberInterface $teamMember, $permission);
}
