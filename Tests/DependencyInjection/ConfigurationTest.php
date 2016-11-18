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
}