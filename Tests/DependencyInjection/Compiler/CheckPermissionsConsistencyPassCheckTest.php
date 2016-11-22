<?php

namespace Quef\TeamBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Quef\TeamBundle\DependencyInjection\Compiler\CheckPermissionConsistencyPass;
use Quef\TeamBundle\DependencyInjection\Compiler\CheckPermissionsConsistencyPass;
use Quef\TeamBundle\DependencyInjection\Compiler\CheckRolesConsistencyPass;
use Quef\TeamBundle\DependencyInjection\Compiler\RegisterTeamsPass;
use Quef\TeamBundle\DependencyInjection\Configuration;
use Quef\TeamBundle\DependencyInjection\QuefTeamExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CheckPermissionsConsistencyPassCheckTest extends AbstractCompilerPassTestCase
{
    public function registerCompilerPass(ContainerBuilder $container)
    {
        $this->container->addCompilerPass(new RegisterTeamsPass());
        $this->container->addCompilerPass(new CheckPermissionsConsistencyPass($container));
    }

    public function testPermissionsAssociatedToRoleButNotDefinedInPermissionListThrowException()
    {
        $configs = [
            [
                'teams' => [
                    'team1' => [
                        'team' => 'Quef\Bundle\TeamTest',
                        'member' => 'Quef\Bundle\MemberTest',
                        'invite' => 'Quef\Bundle\InviteTest',
                        'roles' => [
                            'role1' => [
                                'permissions' => [
                                    'read'
                                ]
                            ],
                            'role3' => [
                                'permissions' => [
                                    'update'
                                ]
                            ]
                        ],
                        'admin_role' => 'role1',
                        'permissions' => [
                            'create'
                        ]
                    ]
                ]
            ]
        ];

        $extension = new QuefTeamExtension();
        $extension->load($configs, $this->container);

        $this->expectException(\InvalidArgumentException::class);

        $this->container->compile();
    }

}