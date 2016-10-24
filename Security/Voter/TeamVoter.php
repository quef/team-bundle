<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 08/10/16
 * Time: 18:23
 */

namespace Quef\TeamBundle\Security\Voter;


use Quef\TeamBundle\Model\TeamInterface;
use Quef\TeamBundle\Model\TeamMemberInterface;
use Quef\TeamBundle\Model\TeamResourceInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

abstract class TeamVoter extends Voter implements TeamVoterInterface
{
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if($subject instanceof TeamInterface) {
            $team = $subject;
        } elseif($subject instanceof TeamResourceInterface) {
            $team = $subject->getTeam();
        } else {
            throw new \InvalidArgumentException("Invalid team resource");
        }

        if(!$this->getMember($token)->getTeam()->getId() === $team->getId()) {
            // The user must be member of the team
            return false;
        }
        return $this->voteOnResource($attribute, $subject, $token);
    }

    /**
     * @param $attribute
     * @param $subject
     * @param TokenInterface $token
     * @return bool
     */
    abstract protected function voteOnResource($attribute, $subject, TokenInterface $token);

}