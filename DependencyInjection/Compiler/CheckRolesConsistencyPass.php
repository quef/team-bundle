<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 20/11/16
 * Time: 20:34
 */

namespace Quef\TeamBundle\DependencyInjection\Compiler;


use Quef\TeamBundle\Metadata\Metadata;
use Quef\TeamBundle\Metadata\MetadataInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CheckRolesConsistencyPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('quef.teams')) {
            return;
        }

        $teamsConfiguration = $container->getParameter('quef.teams');

        foreach ($teamsConfiguration as $alias => $teamConfiguration) {
            $metadata  = new Metadata($alias, $teamConfiguration);

            $this->ensureOwnerRoleExistsInRoleList($metadata);
            $this->ensureRolesUsedInRoleHierarchyExisInRoleList($metadata);
        }
    }

    private function ensureOwnerRoleExistsInRoleList(MetadataInterface $metadata)
    {
        $alias = $metadata->getAlias();
        $roles = $metadata->getRoles();
        $ownerRole = $metadata->getOwnerRole();

        if (!in_array($ownerRole, $roles)) {
            throw new \InvalidArgumentException(
                sprintf('The owner role %s is not defined in the roles list of team %s', $ownerRole, $alias));
        }
    }

    private function ensureRolesUsedInRoleHierarchyExisInRoleList(MetadataInterface $metadata)
    {
        $alias = $metadata->getAlias();
        $roles = $metadata->getRoles();
        $roleHierarchy = $metadata->getRoleHierarchy();

        $mainRoles = array_keys($roleHierarchy);
        $subRoles = array_unique(array_map(function($a) {  return array_pop($a); }, $roleHierarchy));

        $mergedRoles = array_merge($mainRoles, $subRoles);

        if (!empty($rolesNotFound = array_diff($mergedRoles, $roles))) {
            throw new \InvalidArgumentException(
                sprintf('The roles %s defined in role hierarchy for team %s are not present in role list',
                    print_r($rolesNotFound, true), $alias));
        }
    }
}