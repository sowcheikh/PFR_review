<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileSortieVoter extends Voter
{
    private $security = null;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['EDIT', 'VIEW'])
            && $subject instanceof \App\Entity\ProfileSortie;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'EDIT':
                // logic to determine if the user can EDIT
                return $user->getRoles()[0]==='ROLE_ADMIN' || $user->getRoles()[0]==='ROLE_FORMATEUR';

                break;
            case 'VIEW':
                // logic to determine if the user can VIEW
                return $user->getRoles()[0]==='ROLE_ADMIN' || $user->getRoles()[0]==='ROLE_FORMATEUR' || $user->getRoles()[0]==='ROLE_CM';
                break;
        }

        return false;
    }
}
