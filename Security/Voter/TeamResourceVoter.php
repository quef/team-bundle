<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 08/10/16
 * Time: 18:23
 */

namespace Quef\TeamBundle\Security\Voter;


use Quef\TeamBundle\Model\TeamResourceInterface;
use Quef\TeamBundle\Model\TeamResourceRepositoryInterface;
use Quef\TeamBundle\Security\Permission\TeamMemberPermissionCheckerInterface;
use Quef\TeamBundle\Security\Provider\TeamMemberProviderInterface;
use Quef\TeamBundle\Security\Role\RoleCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

abstract class TeamResourceVoter implements VoterInterface
{
    /** @var RoleCheckerInterface */
    private $roleChecker;

    /** @var TeamMemberPermissionCheckerInterface */
    private $permissionChecker;

    /** @var TeamMemberProviderInterface */
    private $memberProvider;

    /**
     * @return RoleCheckerInterface
     */
    public function getRoleChecker()
    {
        return $this->roleChecker;
    }

    /**
     * @param RoleCheckerInterface $roleChecker
     */
    public function setRoleChecker($roleChecker)
    {
        $this->roleChecker = $roleChecker;
    }

    /**
     * @return TeamMemberPermissionCheckerInterface
     */
    public function getPermissionChecker()
    {
        return $this->permissionChecker;
    }

    /**
     * @param TeamMemberPermissionCheckerInterface $permissionChecker
     */
    public function setPermissionChecker($permissionChecker)
    {
        $this->permissionChecker = $permissionChecker;
    }

    /**
     * @return TeamMemberProviderInterface
     */
    public function getMemberProvider()
    {
        return $this->memberProvider;
    }

    /**
     * @param TeamMemberProviderInterface $memberProvider
     */
    public function setMemberProvider($memberProvider)
    {
        $this->memberProvider = $memberProvider;
    }



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

            if(!$object instanceof TeamResourceInterface) {
                throw new \InvalidArgumentException("Argument is not a valid TeamResourceInterface.");
            }

            if(!$this->isTeamMember($object)) {
                return self::ACCESS_DENIED;
            }

            if ($this->voteOnResource($attribute, $object, $token)) {
                // grant access as soon as at least one attribute returns a positive response
                return self::ACCESS_GRANTED;
            }
        }

        return $vote;
    }

    /**
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->getRoleChecker()->hasRole($role, $this->getMemberProvider()->getCurrentMember());
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->getPermissionChecker()->hasPermission($permission, $this->getMemberProvider()->getCurrentMember());
    }

    /**
     * @param TeamResourceInterface $subject
     * @return bool
     */
    protected function isTeamMember(TeamResourceInterface $subject)
    {
        $member = $this->getMemberProvider()->getCurrentMember();
        if(null !== $member) {
            return $member->getTeam()->getId() === $subject->getTeam()->getId();
        }
        return false;
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
     * @param TeamResourceInterface $resource
     * @param TokenInterface $token
     *
     * @return bool
     */
    abstract protected function voteOnResource($attribute, TeamResourceInterface $resource, TokenInterface $token);

}