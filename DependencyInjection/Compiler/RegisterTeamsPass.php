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
use Quef\TeamBundle\Security\Permission\PermissionProvider;
use Quef\TeamBundle\Security\Permission\RolePermissionChecker;
use Quef\TeamBundle\Security\Permission\TeamMemberPermissionChecker;
use Quef\TeamBundle\Security\Role\RoleChecker;
use Quef\TeamBundle\Security\Role\RoleHierarchy;
use Quef\TeamBundle\Security\Role\RoleProvider;
use Quef\TeamBundle\Security\Voter\TeamPermissionVoter;
use Quef\TeamBundle\Security\Voter\TeamRoleVoter;
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
            $this->addRoleChecker($container, $metadata);
            $this->addRoleVoter($container, $metadata);
            $this->addTeamProvider($container, $metadata);
            $this->addTeamMemberFactory($container, $metadata);
            $this->addInviteFactory($container, $metadata);
            $this->addPermissionProvider($container, $metadata);
            $this->addRolePermissionChecker($container, $metadata);
            $this->addTeamMemberPermissionChecker($container, $metadata);
            $this->addPermissionVoter($container, $metadata);
            $this->addTeamResourceVoter($container, $metadata);
        }
    }


    protected function getMetadataDefinition(MetadataInterface $metadata)
    {
        $definition = new Definition(Metadata::class);
        $definition->setArguments([$metadata->getAlias(), $metadata->getParameters()]);
        return $definition;
    }

    protected function getRoleHierarchyDefinition(MetadataInterface $metadata)
    {
        $definition = new Definition(RoleHierarchy::class);
        $definition->setArguments([$metadata->getRoleHierarchy()]);
        return $definition;
    }

    private function addRoleProvider(ContainerBuilder $container, MetadataInterface $metadata)
    {
        $definition = new Definition(RoleProvider::class);
        $definition->setArguments([$metadata->getRoles(), $metadata->getOwnerRole()]);
        $container->setDefinition($metadata->getServiceId('provider.role'), $definition);
    }

    private function addRoleVoter(ContainerBuilder $container, MetadataInterface $metadata)
    {
        $definition = new Definition(TeamRoleVoter::class);
        $definition->setArguments(array(
            new Reference($metadata->getServiceId('provider.role')),
            new Reference($metadata->getServiceId('checker.role')),
            new Reference($metadata->getMemberProvider()),
        ));
        $definition->addTag('security.voter');
        $definition->setPublic(false);
        $container->setDefinition($metadata->getServiceId('voter.role'), $definition);
    }

    private function addRoleChecker(ContainerBuilder $container, MetadataInterface $metadata)
    {
        $definition = new Definition(RoleChecker::class);
        $definition->setArguments([
            $this->getRoleHierarchyDefinition($metadata),
            $metadata->getOwnerRole()]);
        $container->setDefinition($metadata->getServiceId('checker.role'), $definition);
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
        $definition->addMethodCall('setRoleProvider', [new Reference($metadata->getServiceId('provider.role'))]);
        $container->setDefinition($metadata->getServiceId('factory.member'), $definition);
    }

    private function addPermissionProvider(ContainerBuilder $container, MetadataInterface $metadata)
    {
        $definition = new Definition(PermissionProvider::class, [
            $metadata->getPermissions(),
            $metadata->getRolesConfiguration(),
            $metadata->getOwnerRole(),
            $this->getRoleHierarchyDefinition($metadata)
        ]);
        $container->setDefinition($metadata->getServiceId('provider.permission'), $definition);
    }

    private function addRolePermissionChecker(ContainerBuilder $container, MetadataInterface $metadata)
    {
        $definition = new Definition(RolePermissionChecker::class, [
            new Reference($metadata->getServiceId('provider.permission'))
        ] );
        $container->setDefinition($metadata->getServiceId('checker.role_permission'), $definition);
    }

    private function addTeamMemberPermissionChecker(ContainerBuilder $container, MetadataInterface $metadata)
    {
        $definition = new Definition(TeamMemberPermissionChecker::class, [
            new Reference($metadata->getServiceId('checker.role_permission'))
        ] );
        $container->setDefinition($metadata->getServiceId('checker.team_member_permission'), $definition);
    }

    private function addPermissionVoter(ContainerBuilder $container, MetadataInterface $metadata)
    {
        $definition = new Definition(TeamPermissionVoter::class);
        $definition->setArguments(array(
            new Reference($metadata->getServiceId('provider.permission')),
            new Reference($metadata->getServiceId('checker.team_member_permission')),
            new Reference($metadata->getMemberProvider()),
        ));
        $definition->addTag('security.voter');
        $definition->setPublic(false);
        $container->setDefinition($metadata->getServiceId('voter.permission'), $definition);
    }

    private function addTeamResourceVoter(ContainerBuilder $container, MetadataInterface $metadata)
    {
        $definition = new Definition(TeamPermissionVoter::class);
        $definition->addMethodCall('setRoleChecker', [new Reference($metadata->getServiceId('checker.role'))]);
        $definition->addMethodCall('setPermissionChecker', [new Reference($metadata->getServiceId('checker.team_member_permission'))]);
        $definition->addMethodCall('setMemberProvider', [new Reference($metadata->getMemberProvider())]);
        $definition->setAbstract(true);
        $container->setDefinition($metadata->getServiceId('voter.team_resource'), $definition);
    }
}