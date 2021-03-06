<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 17:01
 */

namespace Quef\TeamBundle\Security\Provider;



use Quef\TeamBundle\Model\TeamInterface;
use Quef\TeamBundle\Model\TeamMemberInterface;

interface TeamProviderInterface
{
    /**
     * @return TeamInterface
     */
    public function getCurrentTeam();
}