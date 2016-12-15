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
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

abstract class TeamResourceVoter implements VoterInterface
{
    /**
     * @return TeamMemberInterface
     */
    public abstract function getMember();

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        // abstain vote by default in case none of the attributes are supported
        $vote = self::ACCESS_ABSTAIN;

        foreach ($attributes as $attribute) {
            if (!$this->supports($attribute, $object)) {
                continue;
            }

            // as soon as at least one attribute is supported, default is to deny access
            $vote = self::ACCESS_DENIED;

            if(!$this->isTeamMember($object)) {
                return self::ACCESS_DENIED;
            }

            if ($this->voteOnAttribute($attribute, $object, $token)) {
                // grant access as soon as at least one attribute returns a positive response
                return self::ACCESS_GRANTED;
            }
        }

        return $vote;
    }

    protected function isTeamMember($subject)
    {
        if($subject instanceof TeamInterface) {
            $team = $subject;
        } elseif($subject instanceof TeamResourceInterface) {
            $team = $subject->getTeam();
        } else {
            throw new \InvalidArgumentException("Invalid team resource");
        }

        return $this->getMember()->getTeam()->getId() === $team->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        throw new \BadMethodCallException('supportsAttribute method is deprecated since version 2.8, to be removed in 3.0');
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        throw new \BadMethodCallException('supportsClass method is deprecated since version 2.8, to be removed in 3.0');
    }



    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed  $subject   The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    abstract protected function supports($attribute, $subject);

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string         $attribute
     * @param mixed          $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    abstract protected function voteOnAttribute($attribute, $subject, TokenInterface $token);

}