<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 21/11/16
 * Time: 19:10
 */

namespace Quef\TeamBundle\DependencyInjection\Compiler;


use Quef\TeamBundle\Metadata\Metadata;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CheckPermissionsConsistencyPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('quef.teams')) {
            return;
        }

        $teamsConfiguration = $container->getParameter('quef.teams');

        foreach ($teamsConfiguration as $alias => $teamConfiguration) {
            $metadata  = new Metadata($alias, $teamConfiguration);

            $this->ensurePermissionsDefinedInRolesExist($metadata);
        }
    }

    public function ensurePermissionsDefinedInRolesExist(Metadata $metadata)
    {
        $alias = $metadata->getAlias();
        $rolesConfiguration = $metadata->getRolesConfiguration();
        $permissions = $metadata->getPermissions();

        $rolesPermissions = array_unique(
            array_values(
                array_map(function($a) { return array_pop($a['permissions']); }, $rolesConfiguration)
            )
        );

        if (!empty($permissionsNotFound = array_diff($rolesPermissions, $permissions))) {
            throw new \InvalidArgumentException(
                sprintf('The permissions %s defined in role permissions for team %s are not present in permissions list',
                    print_r($permissionsNotFound, true), $alias));
        }
    }
}