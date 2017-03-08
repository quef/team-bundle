<?php

namespace Quef\TeamBundle\Tests\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Quef\TeamBundle\DependencyInjection\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration()
    {
        return new Configuration();
    }



    public function testOwnerRoleCannotBeEmpty()
    {
        $this->assertPartialConfigurationIsInvalid(
            [
                [
                    'teams' => [
                        'array' => [
                            'owner_role' => ''
                        ]
                    ]
                ]
            ],
            "teams.*.owner_role"
        );
    }

    public function testOwnerRoleIsRequired()
    {
        $this->assertPartialConfigurationIsInvalid(
            [
                [
                    'teams' => [
                        'array' => []
                    ]
                ]
            ],
            "teams.*.owner_role"
        );
    }

    public function testTeamNodeModelIsNormalized()
    {
        $this->assertProcessedConfigurationEquals(
            [
                [
                    'teams' => [
                        'array' => [
                            'team' => 'TestClass'
                        ]
                    ]
                ]
            ],
            [
                'teams' => [
                    'array' => [
                        'team' => [
                            'model' => 'TestClass'
                        ]
                    ]
                ]
            ],
            "teams.*.team.model"
        );
    }

    public function testTeamNodeProviderIsSetToDefaultIfNotDefined()
    {
        $this->assertProcessedConfigurationEquals(
            [
                [
                    'teams' => [
                        'array' => [
                            'team' => []
                        ]
                    ]
                ]
            ],
            [
                'teams' => [
                    'array' => [
                        'team' => [
                            'provider' => 'quef_team.provider.team.default'
                        ]
                    ]
                ]
            ],
            "teams.*.team.provider"
        );
    }

    public function testTeamNodeModelCannotBeEmpty()
    {
        $this->assertPartialConfigurationIsInvalid(
            [
                [
                    'teams' => [
                        'array' => [
                            'team' => [
                                'model' => ''
                            ]
                        ]
                    ]
                ]
            ],
            "teams.*.team.model"
        );
    }

    public function testTeamNodeModelIsRequired()
    {
        $this->assertPartialConfigurationIsInvalid(
            [
                [
                    'teams' => [
                        'array' => [
                            'team' => []
                        ]
                    ]
                ]
            ],
            "teams.*.team.model"
        );
    }

    public function testMemberNodeModelCannotBeEmpty()
    {
        $this->assertPartialConfigurationIsInvalid(
            [
                [
                    'teams' => [
                        'array' => [
                            'member' => [
                                'model' => ''
                            ]
                        ]
                    ]
                ]
            ],
            "teams.*.member.model"
        );
    }

    public function testMemberNodeModelIsRequired()
    {
        $this->assertPartialConfigurationIsInvalid(
            [
                [
                    'teams' => [
                        'array' => [
                            'member' => []
                        ]
                    ]
                ]
            ],
            "teams.*.member.model"
        );
    }

    public function testInviteNodeModelCannotBeEmpty()
    {
        $this->assertPartialConfigurationIsInvalid(
            [
                [
                    'teams' => [
                        'array' => [
                            'invite' => [
                                'model' => ''
                            ]
                        ]
                    ]
                ]
            ],
            "teams.*.invite.model"
        );
    }

    public function testInviteNodeModelIsRequired()
    {
        $this->assertPartialConfigurationIsInvalid(
            [
                [
                    'teams' => [
                        'array' => [
                            'invite' => []
                        ]
                    ]
                ]
            ],
            "teams.*.invite.model"
        );
    }

    public function testAtLeastOneRoleIsRequired()
    {
        $this->assertPartialConfigurationIsInvalid(
            [
                [
                    'teams' => [
                        'array' => [
                            'roles' => []
                        ]
                    ]
                ]
            ],
            "teams.*.roles"
        );
    }

    public function testPermissionsCanBeDefinedForRole()
    {
        $this->assertConfigurationIsValid(
            [
                [
                    'teams' => [
                        'team1' => [
                            'roles' => [
                                'role1' => [
                                    'permissions' => [
                                        'permission1',
                                        'permission2'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'teams.*.roles.*.permissions'
        );
    }

    public function testRoleNameIsUsedAsKeyInRolesNode()
    {
        $this->assertProcessedConfigurationEquals(
            [
                [
                    'teams' => [
                        'team1' => [
                            'roles' => [
                                ['name' => 'role1']
                            ]
                        ]
                    ]
                ]
            ],
            [
                'teams' => [
                    'team1' => [
                        'roles' => [
                            'role1' => [
                                'permissions' => []
                            ]
                        ]
                    ]
                ]
            ],
            'teams.*.roles.*'
        );
    }

    public function testRoleCanBeDefinedWithoutPermissions()
    {
        $this->assertProcessedConfigurationEquals(
            [
                [
                    'teams' => [
                        'team1' => [
                            'roles' => [
                                'role1',
                                'role2' => [
                                    'permissions' => [
                                        'permission1'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'teams' => [
                    'team1' => [
                        'roles' => [
                            'role1' => [
                                'permissions' => []
                            ],
                            'role2' => [
                                'permissions' => [
                                    'permission1'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'teams.*.roles'
        );
    }

    public function testScalarPermissionsCanBeDefined()
    {
        $this->assertConfigurationIsValid(
            [
                [
                    'teams' => [
                        'team1' => [
                            'permissions' => [
                                'permission1',
                                'permission2'
                            ]
                        ]
                    ]
                ]
            ],
            'teams.*.permissions'
        );
    }

    public function testPermissionsCanBeEmpty()
    {
        $this->assertConfigurationIsValid(
            [
                [
                    'teams' => [
                        'team1' => [
                            'permissions' => []
                        ]
                    ]
                ]
            ],
            'teams.*.permissions'
        );
    }
}