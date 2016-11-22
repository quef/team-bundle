<?php

namespace spec\Quef\TeamBundle\Security\Permission;

use Quef\TeamBundle\Exception\PermissionsNotFoundException;
use Quef\TeamBundle\Security\Permission\PermissionProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Quef\TeamBundle\Security\Permission\PermissionProviderInterface;

class PermissionProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PermissionProvider::class);
        $this->shouldImplement(PermissionProviderInterface::class);
    }

    function let()
    {
        $roleConfiguration = [
            'role1' => [
                'permissions' => [
                    'permission1',
                    'permission2'
                ]
            ],
            'role2' => [
                'permissions' => [
                    'permission3',
                    'permission4'
                ]
            ]
        ];

        $this->beConstructedWith($roleConfiguration);
    }

    function it_provides_permission_for_a_given_role()
    {
        $resultForRole1 = ['permission1', 'permission2'];
        $resultForRole2 = ['permission3', 'permission4'];

        $this->getPermissionsForRole('role1')->shouldReturn($resultForRole1);
        $this->getPermissionsForRole('role2')->shouldReturn($resultForRole2);
    }

    function it_throws_exception_when_trying_to_get_permissions_for_inexistent_role()
    {
        $this->shouldThrow(PermissionsNotFoundException::class)->during('getPermissionsForRole', ['role3']);
    }
}
