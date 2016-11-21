<?php

namespace Quef\TeamBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Quef\TeamBundle\DependencyInjection\Compiler\CheckRolesConsistencyPass;
use Quef\TeamBundle\DependencyInjection\Compiler\RegisterTeamsPass;
use Quef\TeamBundle\DependencyInjection\Configuration;
use Quef\TeamBundle\DependencyInjection\QuefTeamExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CheckRolesConsistencyPassCheckTest extends AbstractCompilerPassTestCase
{
    public function registerCompilerPass(ContainerBuilder $container)
    {
        $this->container->addCompilerPass(new RegisterTeamsPass());
        $this->container->addCompilerPass(new CheckRolesConsistencyPass($container));
    }

    public function testAdminRoleNotDefinedInRoleListThrowException()
    {
        $configs = [
            [
                'teams' => [
                    'team1' => [
                        'team' => 'Quef\Bundle\TeamTest',
                        'member' => 'Quef\Bundle\MemberTest',
                        'invite' => 'Quef\Bundle\InviteTest',
                        'roles' => ['role1', 'role2'],
                        'admin_role' => 'admin_role'
                    ]
                ]
            ]
        ];

        $extension = new QuefTeamExtension();
        $extension->load($configs, $this->container);

        $this->expectException(\InvalidArgumentException::class);

        $this->container->compile();
    }

    public function testRolesInHierarchyNotDefinedInRoleListThrowException()
    {
        $configs = [
            [
                'teams' => [
                    'team1' => [
                        'team' => 'Quef\Bundle\TeamTest',
                        'member' => 'Quef\Bundle\MemberTest',
                        'invite' => 'Quef\Bundle\InviteTest',
                        'roles' => ['role1', 'role2'],
                        'admin_role' => 'role1',
                        'role_hierarchy' => [
                            'role1' => ['role2'],
                            'role2' => ['role3']
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