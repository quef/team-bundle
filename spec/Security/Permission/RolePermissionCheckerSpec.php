<?php

namespace spec\Quef\TeamBundle\Security\Permission;

use Quef\TeamBundle\Security\Permission\RolePermissionChecker;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Quef\TeamBundle\Security\Permission\RolePermissionCheckerInterface;
use Quef\TeamBundle\Security\Permission\PermissionProviderInterface;

class RolePermissionCheckerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RolePermissionChecker::class);
        $this->shouldImplement(RolePermissionCheckerInterface::class);
    }

    function let(
        PermissionProviderInterface $permissionProvider
    ) {
        $this->beConstructedWith($permissionProvider);
    }

    function it_authorizes_a_role_if_a_permission_is_defined_for_the_given_a_role(
        PermissionProviderInterface $permissionProvider
    ) {
        $role = 'role1';
        $permission = 'read';

        $permissionProvider->getPermissionsForRole(Argument::type('string'))->willReturn(['read', 'update']);

        $this->isAuthorized($role, $permission)->shouldReturn(true);
    }

    function it_denies_a_role_if_a_permission_is_not_defined_for_the_given_role(
        PermissionProviderInterface $permissionProvider
    ) {
        $role = 'role1';
        $permission = 'create';

        $permissionProvider->getPermissionsForRole(Argument::type('string'))->willReturn(['read', 'update']);

        $this->isAuthorized($role, $permission)->shouldReturn(false);
    }
}
