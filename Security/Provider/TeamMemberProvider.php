<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 17:18
 */

namespace Quef\TeamBundle\Security\Provider;


use Quef\TeamBundle\Model\TeamMemberInterface;
use Quef\TeamBundle\Model\TeamMemberProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TeamMemberProvider implements TeamMemberProviderInterface
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return TeamMemberInterface
     */
    public function getCurrentMember()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if(!$user instanceof TeamMemberInterface) {
            throw new \InvalidArgumentException(sprintf('%s doesn\'t implements %s. It has to implement it if you want to use the default TeamMemberProvider.', get_class($user), 'Quef\TeamBundle\Model\TeamMemberInterface'));
        }
        return $user;
    }
}