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



    public function testAdminRoleCannotBeEmpty()
    {
        $this->assertPartialConfigurationIsInvalid(
            [
                [
                    'teams' => [
                        'array' => [
                            'admin_role' => ''
                        ]
                    ]
                ]
            ],
            "teams.*.admin_role"
        );
    }

    public function testAdminRoleIsRequired()
    {
        $this->assertPartialConfigurationIsInvalid(
            [
                [
                    'teams' => [
                        'array' => []
                    ]
                ]
            ],
            "teams.*.admin_role"
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
}