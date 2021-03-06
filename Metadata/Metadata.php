<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 16/06/16
 * Time: 23:28
 */

namespace Quef\TeamBundle\Metadata;


class Metadata implements MetadataInterface
{
    /** @var string */
    private $alias;

    /** @var array */
    private $parameters;

    public function __construct($alias, array $parameters)
    {
        $this->alias = $alias;
        $this->parameters = $parameters;
    }
    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    public function getInvite()
    {
        return $this->parameters['invite']['model'];
    }

    public function getMember()
    {
        return $this->parameters['member']['model'];
    }

    public function getMemberProvider()
    {
        return $this->parameters['member']['provider'];
    }

    public function getTeam()
    {
        return $this->parameters['team']['model'];
    }

    public function getTeamProvider()
    {
        return $this->parameters['team']['provider'];
    }

    public function getRoles()
    {
        return array_keys($this->parameters['roles']);
    }

    public function getRolesConfiguration()
    {
        return $this->parameters['roles'];
    }

    public function getRoleHierarchy()
    {
        return $this->parameters['role_hierarchy'];
    }

    public function getOwnerRole()
    {
        return $this->parameters['owner_role'];
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceId($serviceName)
    {
        return sprintf('%s.%s', $this->getAlias(), $serviceName);
    }

    public function getPermissions()
    {
        return $this->parameters['permissions'];
    }
}