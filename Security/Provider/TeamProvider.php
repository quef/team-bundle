<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 06/10/16
 * Time: 17:18
 */

namespace Quef\TeamBundle\Security\Provider;


use Quef\TeamBundle\Model\TeamInterface;
use Quef\TeamBundle\Model\TeamMemberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TeamProvider implements TeamProviderInterface, TeamMemberProviderInterface
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return TeamInterface
     */
    public function getCurrentTeam()
    {
        $team = $this->getCurrentMember()->getTeam();
        if(!$team instanceof TeamInterface) {
            throw new \InvalidArgumentException(sprintf('%s doesn\'t implements %s. It has to implement it if you want to use the DefaultTeamProvider.', get_class($team), 'Quef\TeamBundle\Model\TeamInterface'));
        }
        return $team;
    }

    /**
     * @return TeamMemberInterface
     */
    public function getCurrentMember()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        if(!$user instanceof TeamMemberInterface) {
            throw new \InvalidArgumentException(sprintf('%s doesn\'t implements %s. It has to implement it if you want to use the DefaultTeamProvider.', get_class($user), 'Quef\TeamBundle\Model\TeamMemberInterface'));
        }
        return $user;
    }
}