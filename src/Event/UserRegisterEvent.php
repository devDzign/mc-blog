<?php
/**
 * Created by PhpStorm.
 * User: MCH3730
 * Date: 10/07/2018
 * Time: 18:16
 */

namespace App\Event;


use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserRegisterEvent extends Event
{
    const NAME = 'user.register';
    /**
     * @var User
     */
    private $registerUser;

    /**
     * UserRegisterEvent constructor.
     * @param User $registerUser
     */
    public function __construct(User $registerUser)
    {
        $this->registerUser = $registerUser;
    }


    /**
     * @return User
     */
    public function getRegisterUser(): User
    {
        return $this->registerUser;
    }

}