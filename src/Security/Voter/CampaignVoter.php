<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Campaign;
// use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CampaignVoter extends Voter
{
    public const VIEW = 'view';

    // private $security;

    // public function __construct(Security $security)
    // {
    //     $this->security = $security;
    // }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::VIEW])
            && $subject instanceof \App\Entity\Campaign;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (null === $subject->getOwnedBy()) {
            return false;
        }


        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::VIEW:
                // logic to determine if the user can VIEW
                return $this->canView($subject, $user);
                // return true or false
                break;
        }

        return false;
    }

    private function canView(Campaign $campaign, User $user): bool
    {
        return $user === $campaign->getOwnedBy();
    }
}
