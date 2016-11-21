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
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterTeamsPassTest extends AbstractCompilerPassTestCase
{
    public function registerCompilerPass(ContainerBuilder $container)
    {
        $this->container->addCompilerPass(new RegisterTeamsPass());
    }

    public function testOnePermissionProviderIsRegisteredForEachTeam()
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

        $this->container->compile();

        $roleConfigurationForTeam1 = ['role1' => ['permissions' => ['create', 'read', 'update']]];
        $roleConfigurationForTeam2 = ['role1' => ['permissions' => ['read', 'update']]];

        $this->assertContainerBuilderHasService('team1.provider.permission', PermissionProvider::class);
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('team1.provider.permission', 0, $roleConfigurationForTeam1);

        $this->assertContainerBuilderHasService('team2.provider.permission', PermissionProvider::class);
        $this->assertContainerBuilderHasServiceDefinitionWithArgument('team2.provider.permission', 0, $roleConfigurationForTeam2);
    }
}