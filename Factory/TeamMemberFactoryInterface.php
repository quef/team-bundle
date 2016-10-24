<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 11/10/16
 * Time: 22:36
 */

namespace Quef\TeamBundle\Factory;


use Quef\TeamBundle\Model\InviteInterface;
use Quef\TeamBundle\Model\TeamMemberInterface;

interface TeamMemberFactoryInterface
{
    /** @param InviteInterface $invite
     * @return TeamMemberInterface
     */
    public function createFromInvite(InviteInterface $invite);
}