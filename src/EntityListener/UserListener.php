<?php


namespace App\EntityListener;


use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }


    public function prePersist(User $user)
    {
        $this->encodePassword($user);
    }
    public function preUpdate(User $user)
    {
        $this->encodePassword($user);
    }

    public function encodePassword(User $user)
    {
        $plainPassword = $user->getPlainPassword();
        if($plainPassword === null)
        {
            return;
        }

        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                $plainPassword
            )
        );
        $user->setPlainPassword(null);
    }
}