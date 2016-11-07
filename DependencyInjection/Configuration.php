<?php

namespace Quef\TeamBundle\DependencyInjection;

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
                        ->arrayNode('team')
                            ->children()
                                ->scalarNode('model')
                                    ->isRequired()
                                    ->end()
                                ->scalarNode('provider')
                                    ->defaultValue('quef_team.provider.team.default')
                                    ->end()
                                ->end()
                            ->end()

                        ->arrayNode('member')
                            ->children()
                                ->scalarNode('model')
                                    ->isRequired()
                                    ->end()
                                ->end()
                            ->end()


                        ->arrayNode('invite')
                            ->children()
                                ->scalarNode('model')
                                    ->isRequired()
                                    ->end()
                                ->end()
                            ->end()

                        ->arrayNode('roles')
                            ->prototype('scalar')->end()
                            ->end()
                        ->arrayNode('role_hierarchy')
                            ->useAttributeAsKey('id')
                            ->prototype('array')
                                ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->scalarNode('admin_role')
                            ->isRequired()
                            ->end()
                        ->end()

                    ->end()
                ->end()

            ->end();

        return $treeBuilder;
    }
}
