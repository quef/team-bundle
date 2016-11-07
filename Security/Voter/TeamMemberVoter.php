<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 25/10/16
 * Time: 21:54
 */

namespace Quef\TeamBundle\Security\Voter;


use Quef\TeamBundle\Model\TeamMemberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TeamMemberVoter extends TeamVoter
{
    const EDIT = 'quef_team.member.edit';

    /**
     * @param $attribute
     * @param $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnResource($attribute, $subject, TokenInterface $token)
    {
        // TODO: Implement voteOnResource() method.
    }

    /**
     * @param TokenInterface $token
     * @return TeamMemberInterface
     */
    public function getMember(TokenInterface $token)
    {
        // TODO: Implement getMember() method.
    }

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if(!$subject instanceof TeamMemberInterface) {
            return false;
        }
    }
}