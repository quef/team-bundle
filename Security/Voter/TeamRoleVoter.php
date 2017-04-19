<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 19/12/16
 * Time: 19:21
 */

namespace Quef\TeamBundle\Security\Voter;


use Quef\TeamBundle\Security\Provider\TeamMemberProviderInterface;
use Quef\TeamBundle\Security\Role\RoleCheckerInterface;
use Quef\TeamBundle\Security\Role\RoleProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class TeamRoleVoter implements VoterInterface
{
    /** @var RoleProviderInterface */
    private $roleProvider;
    /** @var RoleCheckerInterface */
    private $roleChecker;
    /** @var TeamMemberProviderInterface */
    private $memberProvider;

    public function __construct(RoleProviderInterface $roleProvider, RoleCheckerInterface $roleChecker, TeamMemberProviderInterface $memberProvider)
    {
        $this->roleProvider = $roleProvider;
        $this->roleChecker = $roleChecker;
        $this->memberProvider = $memberProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return in_array($attribute, $this->roleProvider->getRolesWithOwner());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $result = VoterInterface::ACCESS_ABSTAIN;

        foreach ($attributes as $attribute) {
            if (!$this->supportsAttribute($attribute) || $object) {
                continue;
            }

            $result = VoterInterface::ACCESS_DENIED;

            $member = $this->memberProvider->getCurrentMember();
            if ($member !== null && true === $this->roleChecker->hasRole($attribute, $member)) {
                return VoterInterface::ACCESS_GRANTED;
            }
        }

        return $result;
    }
}