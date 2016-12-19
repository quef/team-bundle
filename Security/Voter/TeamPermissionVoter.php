<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 19/12/16
 * Time: 19:21
 */

namespace Quef\TeamBundle\Security\Voter;


use Quef\TeamBundle\Security\Permission\PermissionProviderInterface;
use Quef\TeamBundle\Security\Permission\TeamMemberPermissionCheckerInterface;
use Quef\TeamBundle\Security\Provider\TeamMemberProviderInterface;
use Quef\TeamBundle\Security\Role\RoleCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class TeamPermissionVoter implements VoterInterface
{
    /** @var PermissionProviderInterface */
    private $permissionProvider;
    /** @var TeamMemberPermissionCheckerInterface */
    private $permissionChecker;
    /** @var TeamMemberProviderInterface */
    private $memberProvider;

    public function __construct(PermissionProviderInterface $permissionProvider, TeamMemberPermissionCheckerInterface $permissionChecker, TeamMemberProviderInterface $memberProvider)
    {
        $this->permissionProvider = $permissionProvider;
        $this->permissionChecker = $permissionChecker;
        $this->memberProvider = $memberProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return in_array($attribute, $this->permissionProvider->getPermissions());
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
            if (!$this->supportsAttribute($attribute)) {
                continue;
            }

            $result = VoterInterface::ACCESS_DENIED;

            $member = $this->memberProvider->getCurrentMember();
            if ($member !== null && true === $this->permissionChecker->hasPermission($attribute, $member)) {
                dump('You permission!');
                return VoterInterface::ACCESS_GRANTED;
            }
        }

        return $result;
    }
}