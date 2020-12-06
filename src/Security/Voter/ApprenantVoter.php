<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ApprenantVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        // dd($subject);
        return in_array($attribute, ['APP_VIEW_ALL', 'APP_VIEW', 'APP_EDIT']);
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
            case 'APP_VIEW_ALL':
                return
                    $user->getRoles()[0] === "ROLE_ADMIN"
                    || $user->getRoles()[0] === "ROLE_FORMATEUR"
                ;
            case 'APP_VIEW':
                // logic to determine if the user can EDIT
                return
                    $user->getRoles()[0] === "ROLE_ADMIN"
                    || $user->getRoles()[0] === "ROLE_FORMATEUR"
                    || $user->getId() === $subject->getId();
                break;
            case 'APP_EDIT':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}
