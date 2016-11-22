<?php

namespace spec\Quef\TeamBundle\Security\Permission;

use Quef\TeamBundle\Model\TeamMemberInterface;
use Quef\TeamBundle\Security\Permission\RolePermissionCheckerInterface;
use Quef\TeamBundle\Security\Permission\TeamMemberPermissionChecker;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Quef\TeamBundle\Security\Permission\TeamMemberPermissionCheckerInterface;

class TeamMemberPermissionCheckerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TeamMemberPermissionChecker::class);
        $this->shouldImplement(TeamMemberPermissionCheckerInterface::class);
    }

    function let(
        RolePermissionCheckerInterface $rolePermissionChecker
    ) {
        $this->beConstructedWith($rolePermissionChecker);
    }

    function it_authorizes_a_team_member_if_a_permission_is_defined_for_his_role(
        TeamMemberInterface $teamMember,
        RolePermissionCheckerInterface $rolePermissionChecker
    ) {
        $teamMember->getTeamRole()->willReturn('role1');

        $rolePermissionChecker->isAuthorized(Argument::type('string'), Argument::type('string'))->willReturn(true);

        $this->isAuthorized($teamMember, 'permission')->shouldReturn(true);
    }

    function it_denies_a_team_member_if_a_permission_is_not_defined_for_his_role(
        TeamMemberInterface $teamMember,
        RolePermissionCheckerInterface $rolePermissionChecker
    ) {
        $teamMember->getTeamRole()->willReturn('role1');

        $rolePermissionChecker->isAuthorized(Argument::type('string'), Argument::type('string'))->willReturn(false);

        $this->isAuthorized($teamMember, 'permission')->shouldReturn(false);
    }
}
