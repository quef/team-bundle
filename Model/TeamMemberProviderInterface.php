<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 17:01
 */

namespace Quef\TeamBundle\Model;


interface TeamMemberProviderInterface
{
    /**
     * @return TeamMemberInterface
     */
    public function getCurrentMember();

}