<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 17:01
 */

namespace Quef\TeamBundle\Model;


interface PermissionGranterInterface
{
    /**
     * @param TeamResourceInterface $resource
     * @return int Mask
     */
    public function grantCreatorPermission(TeamResourceInterface $resource);

    /**
     * @param TeamResourceInterface $resource
     * @param TeamMemberInterface $member
     * @return int Mask
     */
    public function grantMemberPermission(TeamResourceInterface $resource, TeamMemberInterface $member);
}