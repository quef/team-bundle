<?php
/**
 * Created by PhpStorm.
 * User: kef
 * Date: 24/10/16
 * Time: 20:23
 */

namespace Quef\TeamBundle\Factory;


use Quef\TeamBundle\Model\InviteInterface;
use Quef\TeamBundle\Security\Provider\TeamProviderInterface;

class InviteFactory implements InviteFactoryInterface
{
    private $class;

    /** @var TeamProviderInterface */
    private $teamProvider;

    public function __construct($class, TeamProviderInterface $teamProvider)
    {
        $this->class = $class;
        $this->teamProvider = $teamProvider;
    }

    /** @return InviteInterface */
    public function createNew()
    {
        dump($this->class);
        /** @var InviteInterface $invite */
        $invite = new $this->class();
        $invite->setInvitedAt(new \DateTime());

        $bytes = false;
        if (function_exists('openssl_random_pseudo_bytes') && 0 !== stripos(PHP_OS, 'win')) {
            $bytes = openssl_random_pseudo_bytes(16, $strong);
            if (true !== $strong) {
                $bytes = false;
            }
        }
        // let's just hope we got a good seed
        if (false === $bytes) {
            $bytes = hash('sha256', uniqid(mt_rand(), true), true);
        }
        $invite->setCode(base_convert(bin2hex($bytes), 16, 36));
        return $invite;
    }

    /** @return InviteInterface */
    public function createNewForCurrentTeam()
    {
        /** @var InviteInterface $invite */
        $invite = $this->createNew();
        $invite->setTeam($this->teamProvider->getCurrentTeam());
        $invite->setInvitedBy($this->teamProvider->getCurrentMember());
        return $invite;
    }
}