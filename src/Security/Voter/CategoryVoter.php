<?php

namespace App\Security\Voter;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CategoryVoter extends Voter
{

    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['CAN_EDIT'])
            && $subject instanceof \App\Entity\Category;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool //$attribute -> 'can_edit', $subject->la catégory, le $toker permet de recup l'user
    {

        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'CAN_EDIT':
                // logic to determine if the user can EDIT
                // return true or false
                return $subject->getOwner() === $user; //est ce que l'user est le propriétaire de la category
        }

        return false;
    }
}
