<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 21/11/16
 * Time: 17:36
 */

namespace Quef\TeamBundle\Tests\DependencyInjection\Compiler;


use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Quef\TeamBundle\DependencyInjection\Compiler\RegisterTeamsPass;
use Quef\TeamBundle\DependencyInjection\QuefTeamExtension;
use Quef\TeamBundle\Security\Permission\PermissionProvider;
use Quef\TeamBundle\Security\Permission\RolePermissionChecker;
use Quef\TeamBundle\Security\Permission\TeamMemberPermissionChecker;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterTeamsPassTest extends AbstractCompilerPassTestCase
{
    public function registerCompilerPass(ContainerBuilder $container)
    {
        $this->container->addCompilerPass(new RegisterTeamsPass());
    }

    public function setUp()
    {
        parent::setUp();

        $configs = [
            [
                'teams' => [
                    'team1' => [
                        'team' => 'Quef\Bundle\TeamTest',
                        'member' => 'Quef\Bundle\MemberTest',
                        'invite' => 'Quef\Bundle\InviteTest',
                        'roles' => [
                            'role1' => [
                                'permissions' => ['create', 'read', 'update']
                            ]
                        ],
                        'owner_role' => 'owner_role'
                    ],
                    'team2' => [
                        'team' => 'Quef\Bundle\TeamTest',
                        'member' => 'Quef\Bundle\MemberTest',
                        'invite' => 'Quef\Bundle\InviteTest',
                        'roles' => [
                            'role1' => [
                                'permissions' => ['read', 'update']
                            ]
                        ],
                        'owner_role' => 'owner_role'
                    ],
                ]
            ]
        ];

        $extension = new QuefTeamExtension();
        $extension->load($configs, $this->container);

    }

    public function testOnePermissionProviderIsRegisteredForEachTeam()
    {
        $this->container->compile();

        $roleConfigurationForTeam1 = ['role1' => ['permissions' => ['create', 'read', 'update']]];
        $roleConfigurationForTeam2 = ['role1' => ['permissions' => ['read', 'update']]];

        $this->assertContainerBuilderHasService('team1.provider.permission', PermissionProvider::class);
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('team1.provider.permission', 0, $roleConfigurationForTeam1);

        $this->assertContainerBuilderHasService('team2.provider.permission', PermissionProvider::class);
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('team2.provider.permission', 0, $roleConfigurationForTeam2);
    }

    public function testOneRolePermissionCheckerIsRegisteredForEachTeam()
    {
        $this->container->compile();

        $permissionProviderForTeam1 = new Reference('team1.provider.permission');
        $permissionProviderForTeam2 = new Reference('team2.provider.permission');

        $this->assertContainerBuilderHasService('team1.checker.role_permission', RolePermissionChecker::class);
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('team1.checker.role_permission', 0, $permissionProviderForTeam1);

        $this->assertContainerBuilderHasService('team2.checker.role_permission', RolePermissionChecker::class);
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('team2.checker.role_permission', 0, $permissionProviderForTeam2);
    }

    public function testOneTeamMemberPermissionCheckerIsRegisteredForEachTeam()
    {
        $this->container->compile();

        $rolePermissionCheckerForTeam1 = new Reference('team1.checker.role_permission');
        $rolePermissionCheckerForTeam2 = new Reference('team2.checker.role_permission');

        $this->assertContainerBuilderHasService('team1.checker.team_member_permission', TeamMemberPermissionChecker::class);
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('team1.checker.team_member_permission', 0, $rolePermissionCheckerForTeam1);

        $this->assertContainerBuilderHasService('team2.checker.team_member_permission', TeamMemberPermissionChecker::class);
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('team2.checker.team_member_permission', 0, $rolePermissionCheckerForTeam2);
    }
}