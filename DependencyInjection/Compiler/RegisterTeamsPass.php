<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 16/06/16
 * Time: 23:19
 */

namespace Quef\TeamBundle\DependencyInjection\Compiler;


use Quef\TeamBundle\Factory\InviteFactory;
use Quef\TeamBundle\Factory\TeamMemberFactory;
use Quef\TeamBundle\Metadata\Metadata;
use Quef\TeamBundle\Metadata\MetadataInterface;
use Quef\TeamBundle\Security\Role\RoleProvider;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class RegisterTeamsPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('quef.teams')) {
            return;
        }

        $teams = $container->getParameter('quef.teams');
        $registry = $container->getDefinition('quef_team.registry');

        foreach ($teams as $alias => $configuration) {
            $metadata = new Metadata($alias, $configuration);
            $registry->addMethodCall('add', [$this->getMetadataDefinition($metadata)]);
            $this->addRoleProvider($container, $metadata);
            $this->addTeamProvider($container, $metadata);
            $this->addTeamMemberFactory($container, $metadata);
            $this->addInviteFactory($container, $metadata);
        }
    }


    protected function getMetadataDefinition(MetadataInterface $metadata)
    {
        $definition = new Definition(Metadata::class);
        $definition->setArguments([$metadata->getAlias(), $metadata->getParameters()]);
        return $definition;
    }

    private function addRoleProvider(ContainerBuilder $container, MetadataInterface $metadata)
    {
        $definition = new Definition(RoleProvider::class);
        $definition->setArguments([$metadata->getRoles(), $metadata->getAdminRole()]);
        $container->setDefinition($metadata->getServiceId('provider.role'), $definition);
    }

    private function addTeamProvider(ContainerBuilder $container, MetadataInterface $metadata)
    {
        $container->setAlias($metadata->getServiceId('provider.team'), $metadata->getTeamProvider());
    }

    private function addInviteFactory(ContainerBuilder $container, MetadataInterface $metadata)
    {
        $definition = new Definition(InviteFactory::class);
        $definition->setArguments([$metadata->getInvite(), new Reference($metadata->getTeamProvider())]);
        $container->setDefinition($metadata->getServiceId('factory.invite'), $definition);
    }

    private function addTeamMemberFactory(ContainerBuilder $container, MetadataInterface $metadata)
    {
        $definition = new Definition(TeamMemberFactory::class);
        $definition->addMethodCall('setClassName', [$metadata->getMember()]);
        $container->setDefinition($metadata->getServiceId('factory.member'), $definition);
    }
}