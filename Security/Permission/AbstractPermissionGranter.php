<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 17:07
 */

namespace Quef\TeamBundle\Security\Permission;


use Quef\TeamBundle\Model\PermissionGranterInterface;
use Quef\TeamBundle\Model\TeamResourceInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

abstract class AbstractPermissionGranter implements PermissionGranterInterface
{
    /**
     * @param TeamResourceInterface $resource
     * @return int Mask
     */
    public function giveCreatorPermission(TeamResourceInterface $resource)
    {
        return MaskBuilder::MASK_OWNER;
    }
}