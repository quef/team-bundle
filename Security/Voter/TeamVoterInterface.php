<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 08/10/16
 * Time: 18:31
 */

namespace Quef\TeamBundle\Security\Voter;


use Quef\TeamBundle\Model\TeamMemberInterface;
use Quef\TeamBundle\Model\TeamResourceInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

interface TeamVoterInterface extends VoterInterface
{
    /**
     * @param TokenInterface $token
     * @return TeamMemberInterface
     */
    public function getMember(TokenInterface $token);
}