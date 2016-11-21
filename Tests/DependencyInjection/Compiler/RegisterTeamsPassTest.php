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
use Quef\TeamBundle\Security\Permission\PermissionChecker;
use Quef\TeamBundle\Security\Permission\PermissionProvider;
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
                        'admin_role' => 'admin_role'
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
                        'admin_role' => 'admin_role'
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

    public function testOnePermissionCheckerIsRegisteredForEachTeam()
    {
        $this->container->compile();

        $permissionProviderForTeam1 = new Reference('team1.provider.permission');
        $permissionProviderForTeam2 = new Reference('team2.provider.permission');

        $this->assertContainerBuilderHasService('team1.checker.permission', PermissionChecker::class);
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('team1.checker.permission', 0, $permissionProviderForTeam1);

        $this->assertContainerBuilderHasService('team2.checker.permission', PermissionChecker::class);
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('team2.checker.permission', 0, $permissionProviderForTeam2);
    }
}