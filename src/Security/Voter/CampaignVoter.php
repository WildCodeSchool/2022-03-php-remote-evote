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
    public const EDIT = 'edit';
    public const VIEW = 'view';
    public const DELETE = 'delete';

    // private $security;

    // public function __construct(Security $security)
    // {
    //     $this->security = $security;
    // }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof \App\Entity\Campaign;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        // if($this->security->isGranted('ROLE_USER')) return true;

        if(null === $subject->getOwnedBy()) return false;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                return $this->canEdit($subject, $user);
                // return true or false
                break;
            // case self::VIEW:
            //     // logic to determine if the user can VIEW
            //     return $this->canView($subject, $user);
            //     // return true or false
            // case self::DELETE:
            //     // logic to determine if the user can DELETE
            //     return $this->canDelete($subject, $user);
            //     // return true or false

            //     break;
        }

        return false;
    }

    private function canEdit(Campaign $subject, User $user){
        return $user === $subject->getOwnedBy();
    }

    // private function canView(Campaign $campaign, User $user){
    //     return $user === $campaign->getOwnedBy();
    // }

    // private function canDelete(Campaign $campaign, User $user){
    //     return $user === $campaign->getOwnedBy();
    // }
}