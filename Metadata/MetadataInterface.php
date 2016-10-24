<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 17/06/16
 * Time: 12:03
 */

namespace Quef\TeamBundle\Metadata;



interface MetadataInterface
{
    /**
     * @return string
     */
    public function getAlias();
    /**
     * @return array
     */
    public function getParameters();

    /**
     * @return string
     */
    public function getTeam();

    /**
     * @return string
     */
    public function getTeamProvider();

    /**
     * @return string
     */
    public function getMember();

    /**
     * @return string
     */
    public function getInvite();

    /**
     * @return array
     */
    public function getRoles();

    /**
     * @return array
     */
    public function getRoleHierarchy();

    /**
     * @param string $serviceName
     *
     * @return string
     */
    public function getServiceId($serviceName);
}