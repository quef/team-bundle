<?php

namespace Quef\TeamBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('quef_team');

        $rootNode->children()
            ->arrayNode('teams')
                ->useAttributeAsKey('alias')
                ->prototype('array')
                    ->children()
                        ->append($this->addTeamNode())
                        ->append($this->addMemberNode())
                        ->append($this->addInviteNode())
                        ->append($this->addRolesNode())
                        ->append($this->addRoleHierarchyNode())
                        ->scalarNode('admin_role')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }

    public function addTeamNode()
    {
        $node = new ArrayNodeDefinition('team');

        $node
            ->beforeNormalization()
                ->ifString()
                ->then(function ($v) { return array('model' => $v); })
            ->end()
            ->children()
                ->scalarNode('model')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('provider')
                    ->defaultValue('quef_team.provider.team.default')
                ->end()
            ->end()
        ->end();

        return $node;
    }

    public function addMemberNode()
    {
        $node = new ArrayNodeDefinition('member');

        $node
            ->children()
                ->scalarNode('model')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ->end();

        return $node;
    }

    public function addInviteNode()
    {
        $node = new ArrayNodeDefinition('invite');

        $node
            ->children()
                ->scalarNode('model')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ->end();

        return $node;
    }

    public function addRolesNode()
    {
        $node = new ArrayNodeDefinition('roles');

        $node
            ->requiresAtLeastOneElement()
            ->prototype('scalar')
        ->end();

        return $node;
    }

    public function addRoleHierarchyNode()
    {
        $node = new ArrayNodeDefinition('role_hierarchy');

        $node
            ->useAttributeAsKey('id')
            ->prototype('array')
                ->prototype('scalar')->end()
            ->end()
        ->end();

        return $node;
    }
}
